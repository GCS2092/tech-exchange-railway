<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VendorOrderController extends Controller
{
    public function __construct()
    {
        // Le middleware est déjà appliqué dans les routes
    }

    /**
     * Afficher toutes les commandes contenant les produits du vendeur
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Order::whereHas('products', function($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->with(['user', 'products' => function($q) use ($user) {
            $q->where('seller_id', $user->id);
        }]);

        // Filtrage par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrage par date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(15);

        // Calculer les statistiques pour ce vendeur
        $stats = [
            'total_orders' => Order::whereHas('products', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })->count(),
            'pending_orders' => Order::whereHas('products', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })->where('status', 'en attente')->count(),
            'completed_orders' => Order::whereHas('products', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })->where('status', 'livré')->count(),
            'total_revenue' => $this->calculateVendorRevenue($user->id),
        ];

        return view('vendor.orders.index', compact('orders', 'stats'));
    }

    /**
     * Afficher une commande spécifique avec seulement les produits du vendeur
     */
    public function show(Order $order)
    {
        $user = auth()->user();
        
        // Vérifier que la commande contient des produits de ce vendeur
        $vendorProducts = $order->products()->where('seller_id', $user->id)->get();
        
        if ($vendorProducts->isEmpty()) {
            abort(403, 'Vous n\'avez pas accès à cette commande.');
        }

        // Charger la commande avec les relations nécessaires
        $order->load(['user', 'products' => function($q) use ($user) {
            $q->where('seller_id', $user->id);
        }]);

        // Calculer le total pour les produits de ce vendeur
        $vendorTotal = $this->calculateVendorOrderTotal($order, $user->id);

        return view('vendor.orders.show', compact('order', 'vendorProducts', 'vendorTotal'));
    }

    /**
     * Marquer les produits du vendeur comme préparés
     */
    public function markAsPrepared(Order $order)
    {
        $user = auth()->user();
        
        // Vérifier que la commande contient des produits de ce vendeur
        $vendorProducts = $order->products()->where('seller_id', $user->id)->get();
        
        if ($vendorProducts->isEmpty()) {
            abort(403, 'Vous n\'avez pas accès à cette commande.');
        }

        // Mettre à jour le statut de la commande si tous les vendeurs ont préparé leurs produits
        $allVendorsPrepared = $this->checkAllVendorsPrepared($order);
        
        if ($allVendorsPrepared) {
            $order->update(['status' => 'en préparation']);
        }

        // Notifier le client
        if ($order->user) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
        }

        return redirect()->back()->with('success', 'Vos produits ont été marqués comme préparés.');
    }

    /**
     * Calculer le revenu total du vendeur
     */
    private function calculateVendorRevenue($vendorId)
    {
        $orders = Order::whereHas('products', function($q) use ($vendorId) {
            $q->where('seller_id', $vendorId);
        })->where('status', 'livré')->with(['products' => function($q) use ($vendorId) {
            $q->where('seller_id', $vendorId);
        }])->get();

        $total = 0;
        foreach ($orders as $order) {
            $total += $this->calculateVendorOrderTotal($order, $vendorId);
        }

        return $total;
    }

    /**
     * Calculer le total d'une commande pour un vendeur spécifique
     */
    private function calculateVendorOrderTotal(Order $order, $vendorId)
    {
        $vendorProducts = $order->products()->where('seller_id', $vendorId)->withPivot(['quantity', 'price'])->get();
        
        $total = 0;
        foreach ($vendorProducts as $product) {
            $quantity = $product->pivot->quantity ?? 1;
            $price = $product->pivot->price ?? $product->price;
            $total += $quantity * $price;
        }

        return $total;
    }

    /**
     * Vérifier si tous les vendeurs ont préparé leurs produits
     */
    private function checkAllVendorsPrepared(Order $order)
    {
        // Cette logique peut être améliorée selon vos besoins
        // Pour l'instant, on considère que si la commande passe en préparation, tous les vendeurs sont prêts
        return true;
    }
} 