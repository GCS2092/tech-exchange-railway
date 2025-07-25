<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Constants\MessageText;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $cacheKey = 'products.index.' . md5(json_encode($request->all()));
        
        $products = Cache::remember($cacheKey, 3600, function () use ($request) {
            $query = Product::query();

            // 🔍 Recherche par nom
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            // 📁 Filtre par catégorie
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // ✅ Filtre par statut
            if ($request->filled('filter')) {
                if ($request->filter === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->filter === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            // 💶 Filtres prix minimum et maximum
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // 🔃 Tri dynamique
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }

            return $query->with(['category'])
                ->latest()
                ->paginate(20);
        });

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $user = auth()->user();
        
        // Seuls les admins peuvent créer des produits
        if (!$user->hasRole('admin')) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        $categories = Category::all();
        $vendeurs = \App\Models\User::role('vendeur')->get();
        return view('products.create', compact('categories', 'vendeurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'image_url' => 'nullable|url',
            'seller_id' => 'required|exists:users,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $imagePath = ltrim(str_replace(['public/', 'storage/'], '', $imagePath), '/');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'is_active' => true,
            'seller_id' => $request->seller_id,
        ]);

        // Invalider le cache des produits
        Cache::forget('products.index');
        
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Produit ajouté avec succès.');
        }
        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function show($id)
    {
        $cacheKey = 'product.' . $id;
        
        $product = Cache::remember($cacheKey, 3600, function () use ($id) {
            return Product::findOrFail($id)->load(['category', 'brand', 'reviews.user']);
        });
        
        // Récupérer les produits similaires de la même catégorie
        $relatedProducts = collect();
        
        if ($product->category_id) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->take(4)
                ->get();
        }
            
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function edit(Product $product)
    {
        $user = auth()->user();
        
        // Seuls les admins peuvent éditer tous les produits
        if (!$user->hasRole('admin')) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'image_url' => 'nullable|url',
        ]);
    
        $imagePath = $product->image;
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $imagePath = ltrim(str_replace(['public/', 'storage/'], '', $imagePath), '/');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }
    
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);
    
        // Invalider le cache pour ce produit et la liste des produits
        Cache::forget('product.' . $product->id);
        Cache::forget('products.index');
    
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Produit mis à jour avec succès.');
        }
        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        
        // Seuls les admins peuvent supprimer tous les produits
        if (!$user->hasRole('admin')) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        $product = Product::findOrFail($id);
        
        // Supprimer l'image associée si elle existe
        if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
            unlink(storage_path('app/public/' . $product->image));
        }
        
        $product->delete();
        
        // Invalider le cache des produits
        Cache::forget('products.index');
        
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès !');
    }

    public function filterByCategory($category_id)
    {
        $categories = Category::all();
        $products = Product::where('category_id', $category_id)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function toggleActive(Product $product)
    {
        $user = auth()->user();
        
        // Seuls les admins peuvent activer/désactiver tous les produits
        if (!$user->hasRole('admin')) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        
        $product->is_active = !$product->is_active;
        $product->save();
        return back()->with('success', 'Statut du produit mis à jour.');
    }

    public function ajaxFilter(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($request->filter === 'inactive') {
            $query->where('is_active', false);
        }

        $products = $query->latest()->get();

        return response()->json([
            'html' => view('products.partials.list', compact('products'))->render()
        ]);
    }

    public function featured()
    {
        $products = \App\Models\Product::where('is_featured', 1)->get();
        return view('products.featured', compact('products'));
    }

    public function inventory()
    {
        // Récupère tous les produits avec leurs informations, y compris la quantité et le stock
        $products = Product::all();
    
        return view('admin.products.inventory', compact('products'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->quantity = $request->quantity;
        $product->save();

        return redirect()->back()->with('success', 'Stock mis à jour avec succès.');
    }

    public function addToFavorites(Product $product)
    {
        auth()->user()->favorites()->attach($product->id);
        return back()->with('success', 'Produit ajouté aux favoris.');
    }

    public function favorite(Product $product)
    {
        $user = auth()->user();

        if (!$user->favorites->contains($product->id)) {
            $user->favorites()->attach($product->id);
        }

        return back()->with('success', 'Produit ajouté aux favoris.');
    }

    public function adminIndex()
    {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            // L'admin voit tous les produits avec les informations du vendeur
            $products = Product::with('seller', 'category')
                ->orderByDesc('created_at')
                ->paginate(15);
        } else {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        
        return view('admin.products.index', compact('products'));
    }
}