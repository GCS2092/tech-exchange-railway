<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class VendorCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Les vendeurs ne voient que les catégories de leurs produits
        if ($user->hasRole('vendeur')) {
            $categoryIds = \App\Models\Product::where('seller_id', $user->id)
                ->distinct()
                ->pluck('category_id');
            $categories = Category::whereIn('id', $categoryIds)->paginate(10);
        } 
        // Les admins voient toutes les catégories
        elseif ($user->hasRole('admin')) {
            $categories = Category::paginate(10);
        } 
        // Autres rôles : pas d'accès
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('vendor.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('categories', 'public');
            $data['image_path'] = 'storage/' . $imagePath;
        }
        \App\Models\Category::create($data);
        return redirect()->route('vendeur.categories.index')->with('success', 'Catégorie ajoutée !');
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
            // Les vendeurs ne peuvent éditer que les catégories de leurs produits
            $categoryIds = \App\Models\Product::where('seller_id', $user->id)
                ->distinct()
                ->pluck('category_id');
            $category = Category::whereIn('id', $categoryIds)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent éditer toutes les catégories
            $category = Category::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('vendor.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $user = auth()->user();
        
        if ($user->hasRole('vendeur')) {
            // Les vendeurs ne peuvent mettre à jour que les catégories de leurs produits
            $categoryIds = \App\Models\Product::where('seller_id', $user->id)
                ->distinct()
                ->pluck('category_id');
            $category = Category::whereIn('id', $categoryIds)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent mettre à jour toutes les catégories
            $category = Category::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($request->hasFile('image_path')) {
            // Supprimer l'ancienne image si elle existe
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                $oldImagePath = str_replace('storage/', '', $category->image_path);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('image_path')->store('categories', 'public');
            $data['image_path'] = 'storage/' . $imagePath;
        }
        $category->update($data);
        return redirect()->route('vendeur.categories.index')->with('success', 'Catégorie modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        if ($user->hasRole('vendeur')) {
            // Les vendeurs ne peuvent supprimer que les catégories de leurs produits
            $categoryIds = \App\Models\Product::where('seller_id', $user->id)
                ->distinct()
                ->pluck('category_id');
            $category = Category::whereIn('id', $categoryIds)->findOrFail($id);
        } 
        elseif ($user->hasRole('admin')) {
            // Les admins peuvent supprimer toutes les catégories
            $category = Category::findOrFail($id);
        } 
        else {
            abort(403, 'Accès non autorisé.');
        }
        // Vérifier s'il y a des produits associés
        $productsCount = $category->products()->count();
        if ($productsCount > 0) {
            return back()->withErrors(['error' => "Impossible de supprimer la catégorie car elle contient {$productsCount} produit(s). Supprimez d'abord les produits associés."]);
        }
        // Supprimer l'image associée si elle existe
        if ($category->image_path && file_exists(public_path($category->image_path))) {
            $imagePath = str_replace('storage/', '', $category->image_path);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
        }
        $category->delete();
        return redirect()->route('vendeur.categories.index')->with('success', 'Catégorie supprimée !');
    }
}
