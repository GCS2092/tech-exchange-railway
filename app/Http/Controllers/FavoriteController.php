<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = \App\Models\Favorite::with('product')
            ->where('user_id', auth()->id())
            ->get();
    
        return view('favorites.index', compact('favorites'));
    }
    

    public function add(Product $product) {
        // Vérifiez d'abord si le favori existe déjà
        $exists = Auth::user()->favorites()->where('product_id', $product->id)->exists();
        
        if (!$exists) {
            // Création d'un nouveau favori
            $favorite = new Favorite();
            $favorite->user_id = Auth::user()->id;
            $favorite->product_id = $product->id;
            $favorite->save();
        }
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté aux favoris !'
            ]);
        }
        
        return back()->with('success', 'Produit ajouté aux favoris !');
    }

    public function remove(Product $product) {
        Auth::user()->favorites()->where('product_id', $product->id)->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit retiré des favoris.'
            ]);
        }
        
        return back()->with('success', 'Produit retiré des favoris.');
    }

    public function toggle(Product $product) {
        $user = Auth::user();
        $exists = $user->favorites()->where('product_id', $product->id)->exists();
        
        if ($exists) {
            // Retirer des favoris
            $user->favorites()->where('product_id', $product->id)->delete();
            $message = 'Produit retiré des favoris.';
            $action = 'removed';
        } else {
            // Ajouter aux favoris
            $favorite = new Favorite();
            $favorite->user_id = $user->id;
            $favorite->product_id = $product->id;
            $favorite->save();
            $message = 'Produit ajouté aux favoris !';
            $action = 'added';
        }
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $action
            ]);
        }
        
        return back()->with('success', $message);
    }

    public function clear() {
        Auth::user()->favorites()->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tous les favoris ont été supprimés.'
            ]);
        }
        
        return back()->with('success', 'Tous les favoris ont été supprimés.');
    }
}
