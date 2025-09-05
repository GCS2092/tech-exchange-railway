<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        $reviews = $product->reviews()->with('user')->paginate(10);
        return response()->json($reviews);
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Vérifier si l'utilisateur a déjà acheté le produit
        $hasPurchased = Auth::user()->orders()
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 'delivered')
            ->exists();

        if (!$hasPurchased) {
            return response()->json(['message' => 'Vous devez avoir acheté ce produit pour laisser un avis'], 403);
        }

        // Vérifier si l'utilisateur a déjà laissé un avis
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($existingReview) {
            return response()->json(['message' => 'Vous avez déjà laissé un avis sur ce produit'], 403);
        }

        $review = $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json(['review' => $review], 201);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'integer|min:1|max:5',
            'comment' => 'string|max:1000',
        ]);

        $review->update($validated);
        return response()->json(['review' => $review]);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return response()->json(null, 204);
    }

    public function report(Review $review)
    {
        $validated = request()->validate([
            'reason' => 'required|string|max:255',
        ]);

        $review->reports()->create([
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
        ]);

        return response()->json(['message' => 'Avis signalé avec succès']);
    }
} 