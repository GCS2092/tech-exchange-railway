<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('product')->get();
        return response()->json(['favorites' => $favorites]);
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Produit retiré des favoris']);
        }

        $user->favorites()->create(['product_id' => $product->id]);
        return response()->json(['message' => 'Produit ajouté aux favoris']);
    }

    public function destroy(Product $product)
    {
        Auth::user()->favorites()->where('product_id', $product->id)->delete();
        return response()->json(['message' => 'Produit retiré des favoris']);
    }
} 