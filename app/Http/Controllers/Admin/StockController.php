<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.stocks.index', compact('products'));
    }
}
