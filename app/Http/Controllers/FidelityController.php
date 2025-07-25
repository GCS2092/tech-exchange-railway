<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class FidelityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if (!$user) {
            abort(403, 'Non autorisé');
        }
    
        $orders = $user->orders()->where('total_price', '>=', 5000)->get();
    
        return view('fidelity.calendar', compact('orders'));
    }
    
}
