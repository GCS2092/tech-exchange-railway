<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Affiche la liste de toutes les catégories
     */
    public function index()
    {
        try {
            // Cache les catégories avec le nombre de produits pour 1 heure
            $categories = Cache::remember('categories.index', 3600, function () {
                return Category::withCount('products')
                    ->orderBy('name')
                    ->get();
            });

            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des catégories: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors du chargement des catégories.']);
        }
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie
     */
    public function create()
    {
        $vendeurs = \App\Models\User::role('vendeur')->get();
        return view('categories.create', compact('vendeurs'));
    }

    /**
     * Enregistre une nouvelle catégorie
     */
    public function store(Request $request)
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            // Validation des données
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string|max:1000',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'seller_id' => 'required|exists:users,id',
            ], [
                'name.required' => 'Le nom de la catégorie est obligatoire.',
                'name.unique' => 'Cette catégorie existe déjà.',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
                'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
                'image_path.image' => 'Le fichier doit être une image.',
                'image_path.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif ou webp.',
                'image_path.max' => 'L\'image ne peut pas dépasser 2MB.',
                'seller_id.required' => 'Le vendeur est obligatoire.',
                'seller_id.exists' => 'Le vendeur sélectionné est invalide.',
            ]);

            DB::beginTransaction();

            $data = [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'seller_id' => $validatedData['seller_id'],
            ];

            // Gestion de l'upload d'image
            if ($request->hasFile('image_path')) {
                try {
                    $imagePath = $request->file('image_path')->store('categories', 'public');
                    $data['image_path'] = 'storage/' . $imagePath;
                } catch (\Exception $e) {
                    Log::error('Erreur upload image catégorie: ' . $e->getMessage());
                    throw new \Exception('Erreur lors de l\'upload de l\'image.');
                }
            }

            // Créer la catégorie
            $category = Category::create($data);

            DB::commit();

            // Invalider le cache
            Cache::forget('categories.index');
            Cache::tags(['categories'])->flush();

            return redirect()->route('categories.index')
                ->with('success', 'Catégorie "' . $category->name . '" créée avec succès.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création catégorie: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Affiche une catégorie spécifique avec ses produits
     */
    public function show(Category $category)
    {
        try {
            $cacheKey = 'category.' . $category->id . '.products';
            
            // Cache la catégorie avec ses produits paginés
            $categoryData = Cache::remember($cacheKey, 1800, function () use ($category) {
                return [
                    'category' => $category->load('products.brand'),
                    'productsCount' => $category->products()->count()
                ];
            });

            // Pagination des produits (non mise en cache pour permettre la navigation)
            $products = $category->products()
                ->with(['brand'])
                ->paginate(12);

            return view('categories.show', [
                'category' => $categoryData['category'],
                'products' => $products,
                'productsCount' => $categoryData['productsCount']
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur affichage catégorie: ' . $e->getMessage());
            return redirect()->route('categories.index')
                ->withErrors(['error' => 'Erreur lors du chargement de la catégorie.']);
        }
    }

    /**
     * Affiche le formulaire d'édition d'une catégorie
     */
    public function edit(Category $category)
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('categories.edit', compact('category'));
    }

    /**
     * Met à jour une catégorie existante
     */
    public function update(Request $request, Category $category)
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            // Validation des données
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string|max:1000',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ], [
                'name.required' => 'Le nom de la catégorie est obligatoire.',
                'name.unique' => 'Cette catégorie existe déjà.',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
                'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
                'image_path.image' => 'Le fichier doit être une image.',
                'image_path.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif ou webp.',
                'image_path.max' => 'L\'image ne peut pas dépasser 2MB.'
            ]);

            DB::beginTransaction();

            $data = [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
            ];

            // Gestion de l'upload d'une nouvelle image
            if ($request->hasFile('image_path')) {
                try {
                    // Supprimer l'ancienne image si elle existe
                    if ($category->image_path && file_exists(public_path($category->image_path))) {
                        $oldImagePath = str_replace('storage/', '', $category->image_path);
                        Storage::disk('public')->delete($oldImagePath);
                    }

                    // Upload de la nouvelle image
                    $imagePath = $request->file('image_path')->store('categories', 'public');
                    $data['image_path'] = 'storage/' . $imagePath;
                } catch (\Exception $e) {
                    Log::error('Erreur upload image catégorie (update): ' . $e->getMessage());
                    throw new \Exception('Erreur lors de l\'upload de l\'image.');
                }
            }

            // Mettre à jour la catégorie
            $category->update($data);

            DB::commit();

            // Invalider les caches
            Cache::forget('categories.index');
            Cache::forget('category.' . $category->id);
            Cache::forget('category.' . $category->id . '.products');
            Cache::tags(['categories'])->flush();

            return redirect()->route('categories.show', $category)
                ->with('success', 'Catégorie "' . $category->name . '" mise à jour avec succès.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour catégorie: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Supprime une catégorie
     */
    public function destroy(Category $category)
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            DB::beginTransaction();

            // Vérifier s'il y a des produits associés
            $productsCount = $category->products()->count();
            if ($productsCount > 0) {
                return back()->withErrors([
                    'error' => "Impossible de supprimer la catégorie « {$category->name} » car elle contient {$productsCount} produit(s). Supprimez d'abord les produits associés."
                ]);
            }

            $categoryName = $category->name;

            // Supprimer l'image associée si elle existe
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                try {
                    $imagePath = str_replace('storage/', '', $category->image_path);
                    Storage::disk('public')->delete($imagePath);
                } catch (\Exception $e) {
                    Log::warning('Impossible de supprimer l\'image de la catégorie: ' . $e->getMessage());
                    // Continuer même si la suppression de l'image échoue
                }
            }

            // Supprimer la catégorie
            $category->delete();

            DB::commit();

            // Invalider tous les caches liés aux catégories
            Cache::forget('categories.index');
            Cache::forget('category.' . $category->id);
            Cache::forget('category.' . $category->id . '.products');
            Cache::tags(['categories'])->flush();

            return redirect()->route('categories.index')
                ->with('success', 'Catégorie "' . $categoryName . '" supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur suppression catégorie: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors de la suppression de la catégorie.']);
        }
    }

    /**
     * Recherche dans les catégories (AJAX)
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            
            if (strlen($query) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'La recherche doit contenir au moins 2 caractères.'
                ]);
            }

            $categories = Category::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->withCount('products')
                ->orderBy('name')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories,
                'count' => $categories->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur recherche catégories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche.'
            ], 500);
        }
    }

    /**
     * Obtient les statistiques des catégories (pour le dashboard admin)
     */
    public function stats()
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            $stats = Cache::remember('categories.stats', 1800, function () {
                return [
                    'total_categories' => Category::count(),
                    'categories_with_products' => Category::has('products')->count(),
                    'categories_without_products' => Category::doesntHave('products')->count(),
                    'average_products_per_category' => Category::withCount('products')->avg('products_count'),
                    'most_popular_categories' => Category::withCount('products')
                        ->orderBy('products_count', 'desc')
                        ->limit(5)
                        ->get(),
                    'recent_categories' => Category::latest()
                        ->limit(5)
                        ->get()
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur stats catégories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statistiques.'
            ], 500);
        }
    }

    /**
     * Exporte les catégories au format CSV
     */
    public function export()
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            $categories = Category::withCount('products')->orderBy('name')->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="categories_' . date('Y-m-d') . '.csv"',
            ];

            $callback = function() use ($categories) {
                $file = fopen('php://output', 'w');
                
                // Ajouter le BOM UTF-8 pour Excel
                fwrite($file, "\xEF\xBB\xBF");
                
                // En-têtes CSV
                fputcsv($file, [
                    'ID',
                    'Nom',
                    'Description',
                    'Nombre de produits',
                    'A une image',
                    'Date de création',
                    'Dernière modification'
                ], ';');

                // Données
                foreach ($categories as $category) {
                    fputcsv($file, [
                        $category->id,
                        $category->name,
                        $category->description ?? '',
                        $category->products_count,
                        $category->image_path ? 'Oui' : 'Non',
                        $category->created_at->format('d/m/Y H:i'),
                        $category->updated_at->format('d/m/Y H:i')
                    ], ';');
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Erreur export catégories: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors de l\'export des catégories.']);
        }
    }

    /**
     * Duplique une catégorie (sans ses produits)
     */
    public function duplicate(Category $category)
    {
        // Vérifier les permissions admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            DB::beginTransaction();

            $newCategory = $category->replicate();
            $newCategory->name = $category->name . ' (Copie)';
            
            // Dupliquer l'image si elle existe
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                $originalImagePath = str_replace('storage/', '', $category->image_path);
                $extension = pathinfo($originalImagePath, PATHINFO_EXTENSION);
                $newImageName = 'categories/' . uniqid() . '.' . $extension;
                
                Storage::disk('public')->copy($originalImagePath, $newImageName);
                $newCategory->image_path = 'storage/' . $newImageName;
            }
            
            $newCategory->save();

            DB::commit();

            // Invalider le cache
            Cache::forget('categories.index');
            Cache::tags(['categories'])->flush();

            return redirect()->route('categories.show', $newCategory)
                ->with('success', 'Catégorie dupliquée avec succès sous le nom "' . $newCategory->name . '".');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur duplication catégorie: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors de la duplication de la catégorie.']);
        }
    }
}