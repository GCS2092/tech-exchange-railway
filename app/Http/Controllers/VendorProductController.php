<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class VendorProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Les vendeurs ne voient que leurs produits
        if ($user->hasRole('vendeur')) {
            $products = Product::where('seller_id', $user->id)->paginate(10);
        } 
        // Les admins voient tous les produits avec information du vendeur
        elseif ($user->hasRole('admin')) {
            $products = Product::with('seller')->paginate(10);
        } 
        // Autres rôles : pas d'accès
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'currency' => 'required|string|in:XOF',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'image_url' => 'nullable|url', // assoupli : accepte tout lien http/https
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $imagePath = ltrim(str_replace(['public/', 'storage/'], '', $imagePath), '/');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }
        $product = \App\Models\Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'seller_id' => auth()->id(),
            'is_active' => true,
        ]);
        return redirect()->route('vendeur.products.index')->with('success', 'Produit ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user();
        
        if ($user->hasRole('vendeur')) {
            // Les vendeurs ne peuvent éditer que leurs produits
            $product = Product::where('seller_id', $user->id)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent éditer tous les produits
            $product = Product::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        $categories = \App\Models\Category::all();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $user = auth()->user();
        
        if ($user->hasRole('vendeur')) {
            // Les vendeurs ne peuvent mettre à jour que leurs produits
            $product = Product::where('seller_id', $user->id)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent mettre à jour tous les produits
            $product = Product::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $product->update(array_merge(
            $request->only('name', 'price', 'quantity', 'category_id'),
            ['seller_id' => $product->seller_id] // Garder le vendeur original
        ));
        
        return redirect()->route('vendeur.products.index')->with('success', 'Produit modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        if ($user->hasRole('vendeur')) {
            // Les vendeurs ne peuvent supprimer que leurs produits
            $product = Product::where('seller_id', $user->id)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent supprimer tous les produits
            $product = Product::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        $product->delete();
        return redirect()->route('vendeur.products.index')->with('success', 'Produit supprimé !');
    }

    public function toggle($id)
    {
        $user = auth()->user();
        
        if ($user->hasRole('vendeur')) {
            // Les vendeurs ne peuvent modifier que leurs produits
            $product = Product::where('seller_id', $user->id)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent modifier tous les produits
            $product = Product::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        $product->is_active = !$product->is_active;
        $product->save();
        return back()->with('success', 'Statut du produit mis à jour.');
    }
}
