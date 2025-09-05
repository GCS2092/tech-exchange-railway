<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorDashboardController extends Controller
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
            $products = Product::where('seller_id', $user->id)->latest()->paginate(10);
            $orders = Order::whereHas('products', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })->with('user')->latest()->take(10)->get();
        } else {
            // Admin voit tous les produits et commandes
            $products = Product::with('seller')->latest()->paginate(10);
            $orders = Order::with('user')->latest()->take(10)->get();
        }
        
        $stats = [
            'products_count' => $user->hasRole('vendeur') ? $user->products()->count() : Product::count(),
            'orders_count' => $orders->count(),
            'total_sales' => $this->calculateTotalSales($user),
        ];
        
        // Ventes par mois (12 derniers mois)
        $salesByMonth = $this->calculateSalesByMonth($user);
        $months = collect(range(0, 11))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse();
        
        return view('vendor.dashboard', compact('products', 'orders', 'stats', 'salesByMonth', 'months'));
    }
    
    private function calculateTotalSales($user)
    {
        if ($user->hasRole('vendeur')) {
            return $user->products()->with('orderItems.order')->get()->reduce(function($carry, $product) {
                return $carry + $product->orderItems->sum(function($item) { 
                    return $item->quantity * $item->price; 
                });
            }, 0);
        } else {
            // Admin voit toutes les ventes
            return Order::where('status', 'livré')->sum('total_price');
        }
    }
    
    private function calculateSalesByMonth($user)
    {
        if ($user->hasRole('vendeur')) {
            return $user->products()
                ->with(['orderItems.order' => function($q) {
                    $q->where('status', 'livré');
                }])
                ->get()
                ->flatMap(function($product) {
                    return $product->orderItems;
                })
                ->filter(function($item) {
                    return $item->order && $item->order->created_at;
                })
                ->groupBy(function($item) {
                    return $item->order->created_at->format('Y-m');
                })
                ->map(function($items) {
                    return $items->sum(function($item) { 
                        return $item->quantity * $item->price; 
                    });
                });
        } else {
            // Admin voit toutes les ventes par mois
            return Order::where('status', 'livré')
                ->get()
                ->groupBy(function($order) {
                    return $order->created_at->format('Y-m');
                })
                ->map(function($orders) {
                    return $orders->sum('total_price');
                });
        }
    }
} 