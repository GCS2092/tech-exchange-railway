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
        
        return back()->with('success', 'Produit ajouté aux favoris !');
    }

    public function remove(Product $product) {
        Auth::user()->favorites()->where('product_id', $product->id)->delete();
        return back()->with('success', 'Produit retiré des favoris.');
    }
}
