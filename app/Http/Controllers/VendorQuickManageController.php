<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class VendorQuickManageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Vérifier que l'utilisateur a le rôle vendeur ou admin
        if (!$user->hasRole(['vendeur', 'admin'])) {
            abort(403, 'Accès réservé aux vendeurs et administrateurs.');
        }
        
        // Les vendeurs ne voient que leurs produits, les admins voient tout
        if ($user->hasRole('vendeur')) {
            $products = Product::where('seller_id', $user->id)->get();
            // Les vendeurs ne voient que les catégories de leurs produits
            $categoryIds = $products->pluck('category_id')->unique();
            $categories = Category::whereIn('id', $categoryIds)->get();
        } else {
            // Admin voit tous les produits et toutes les catégories
            $products = Product::with('seller')->get();
            $categories = Category::all();
        }
        return view('vendor.quickmanage', compact('products', 'categories'));
    }
}
