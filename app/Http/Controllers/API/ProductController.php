<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtrage par recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filtrage par catégorie
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Tri
        if ($request->has('sort')) {
            $sort = $request->sort;
            if (str_starts_with($sort, '-')) {
                $query->orderBy(substr($sort, 1), 'desc');
            } else {
                $query->orderBy($sort, 'asc');
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function featured()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->take(8)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $featuredProducts
        ]);
    }

    public function filterByCategory($category)
    {
        $products = Product::where('category', $category)->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('categories')) {
            $query->whereIn('category', $request->categories);
        }

        $products = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
} 