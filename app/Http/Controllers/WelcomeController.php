<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->take(8)
            ->get();

        return view('welcome', compact('featuredProducts'));
    }
} 