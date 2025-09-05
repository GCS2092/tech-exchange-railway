<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\CommandAssignedToLivreur;
use App\Models\PromoUsage;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderStatusUpdatedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    use AuthorizesRequests;

    private const PAYMENT_METHODS = ['livraison', 'wave_delivery', 'orange_delivery', 'cash_delivery'];
    private const CURRENCIES = ['XOF', 'EUR', 'USD'];

    public function index()
{
    $cacheKey = 'orders.user.' . auth()->id();
    
    $orders = Cache::remember($cacheKey, 3600, function () {
        return auth()->user()->orders()
            ->with(['user', 'products'])
            ->latest()
            ->paginate(10);
    });

    Log::info('Commandes utilisateur récupérées', [
        'user_id' => auth()->id(),
        'count' => $orders->count(),
        'orders' => $orders->pluck('id')->toArray()
    ]);
    
    $ordersPerMonth = Cache::remember('orders.monthly.' . auth()->id(), 3600, function () {
        return Order::select(
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('user_id', auth()->id())
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [date('Y')])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
    });
    
    return view('orders.index', compact('orders', 'ordersPerMonth'));
}

   public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'phone_number' => 'nullable|string|regex:/^\+?\d{8,15}$/',
        'payment_method' => ['required', Rule::in(self::PAYMENT_METHODS)],
        'currency' => ['required', Rule::in(self::CURRENCIES)],
        'delivery_address' => 'required|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'shipping_address' => 'nullable|string|max:255',
        'billing_address' => 'nullable|string|max:255',
    ]);

    // Récupérer le panier
    $cartKey = 'cart.' . auth()->id();
    $cart = Cache::remember($cartKey, 3600, function () {
        return auth()->user()->cartItems()->with('product')->get();
    });

    if ($cart->isEmpty()) {
        Log::warning('Tentative de création de commande avec panier vide', ['user_id' => auth()->id()]);
        return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
    }

    // Calculer les totaux
    $originalTotal = $this->calculateCartTotal($cart);
    $total = $originalTotal;
    $promo = session()->get('promo');
    $discountAmount = 0;

    if ($promo) {
        $discountAmount = $total * ($promo['value'] / 100);
        $total -= $discountAmount;
    }

    if ($total < 100 && $request->currency === 'XOF') {
        Log::warning('Montant de commande trop bas', ['total' => $total, 'currency' => $request->currency]);
        return redirect()->route('checkout.index')->with('error', 'Le montant minimum pour passer une commande est de 100 FCFA.');
    }

    // Créer la commande
    try {
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'original_price' => $originalTotal,
            'discount_amount' => $discountAmount,
            'promo_code' => $promo['code'] ?? null,
            'status' => 'en attente',
            'payment_method' => $request->payment_method,
            'phone_number' => $request->phone_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'delivery_address' => $request->delivery_address,
            'shipping_address' => $request->shipping_address ?? $request->delivery_address,
            'billing_address' => $request->billing_address ?? $request->delivery_address,
        ]);

        Log::info('Commande créée avec succès', [
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'total_price' => $total,
            'products' => $cart->pluck('product_id')->toArray()
        ]);

        // CORRECTION: Gestion atomique des stocks avec transaction
        try {
            DB::transaction(function () use ($cart, $order) {
            foreach ($cart as $item) {
                $product = $item->product;
                
                // Vérifier le stock de manière atomique
                $currentStock = DB::table('products')
                    ->where('id', $product->id)
                    ->where('quantity', '>=', $item->quantity)
                    ->lockForUpdate()
                    ->value('quantity');
                
                if (!$currentStock) {
                    throw new \Exception('Stock insuffisant pour ' . $product->name . '. Il reste seulement ' . $product->quantity . ' unités disponibles.');
                }
                
                // Attacher le produit à la commande
                $order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $item->price ?? $product->price
                ]);
                
                // Décrémenter le stock de manière atomique
                $newStock = DB::table('products')
                    ->where('id', $product->id)
                    ->decrement('quantity', $item->quantity);
                
                // Recharger le produit pour avoir le nouveau stock
                $product->refresh();
                
                // Alerte stock faible
                if ($product->quantity <= 10) {
                    try {
                        \Mail::to(config('mail.admin_email', 'admin@example.com'))->send(new \App\Mail\LowStockAlertMail($product));
                    } catch (\Exception $e) {
                        Log::warning('Échec de l\'envoi de l\'alerte stock faible', [
                            'product_id' => $product->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
                
                Log::info('Stock décrémenté pour commande', [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity_ordered' => $item->quantity,
                    'new_stock' => $product->quantity
                ]);
            }
        });
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la commande', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'cart_items' => $cart->count()
            ]);
            
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        // Enregistrer l'utilisation de la promo
        if ($promo) {
            PromoUsage::create([
                'user_id' => auth()->id(),
                'promotion_id' => $promo['id'],
                'order_id' => $order->id,
                'original_amount' => $originalTotal,
                'discount_amount' => $discountAmount,
            ]);
        }

        // Nettoyer le panier et le cache
        auth()->user()->cartItems()->delete();
        Cache::forget($cartKey);
        Cache::forget('orders.user.' . auth()->id());
        Cache::forget('dashboard.stats');

        // Envoyer les notifications
        $order->load('user', 'products');
        $order->user->notify(new OrderPlacedNotification($order));
        
        // Notifier uniquement les vendeurs des produits commandés
        $sellers = $order->products->pluck('seller')->unique()->filter();
        foreach ($sellers as $seller) {
            if ($seller) {
                $seller->notify(new \App\Notifications\VendorOrderNotification($order));
            }
        }
        
        // Notifier les admins
        User::role('admin')->get()->each(fn($admin) => $admin->notify(new NewOrderNotification($order)));

        // Redirection
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Commande créée avec succès.');
        }

        return redirect()->route('orders.index')->with('success', 'Votre commande a été validée avec succès' . 
            ($promo ? ' avec une réduction de ' . number_format($discountAmount, 2) . ' ' . $request->currency : '') . '.');
    } catch (\Exception $e) {
        Log::error('Erreur lors de la création de la commande', [
            'user_id' => auth()->id(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->route('checkout.index')->with('error', 'Une erreur est survenue lors de la création de la commande.');
    }
}

    protected function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $itemPrice = $item->price ?? ($item->product->price ?? 0);
            $total += $itemPrice * $item->quantity;

            Log::debug('Item price calculation', [
                'item_id' => $item->id ?? 'unknown',
                'item_price' => $item->price ?? 'null',
                'product_price' => $item->product->price ?? 'null',
                'used_price' => $itemPrice,
                'quantity' => $item->quantity ?? 1,
                'subtotal' => $itemPrice * ($item->quantity ?? 1)
            ]);
        }
        return $total;
    }

    public function clear()
    {
        if (auth()->user()->hasRole('admin')) {
            DB::transaction(function () {
                DB::table('order_product')->delete();
                Order::query()->delete();
            });
        } else {
            Order::where('user_id', auth()->id())->delete();
        }

        Cache::forget('orders.user.' . auth()->id());
        Cache::forget('dashboard.stats'); // Invalidation du cache du tableau de bord

        return redirect()->back()->with('success', 'Commandes supprimées avec succès.');
    }

    public function adminIndex(Request $request)
    {
        $this->authorizeAdmin();

        $orders = Order::query()->with(['user', 'products']);

        if ($request->filled('date')) {
            $date = $request->date;
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $orders->whereDate('created_at', $date);
            }
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if (array_key_exists($status, Order::STATUSES)) {
                $orders->where('status', $status);
            }
        }

        $orders = $orders->orderBy('created_at', 'desc')->paginate(20);
        Log::info('Commandes admin récupérées', ['count' => $orders->count()]);

        $enAttente = Order::where('status', 'en attente')->count();
        $expedie = Order::where('status', 'expédié')->count();
        $livre = Order::where('status', 'livré')->count();

        $statusCounts = [
            'En attente' => $enAttente,
            'Expédié' => $expedie,
            'Livré' => $livre,
        ];

        $monthlyOrders = DB::table('orders')
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        $ordersPerMonth = collect(range(1, 12))->map(fn($month) => $monthlyOrders[$month] ?? 0)->toArray();

        return view('orders.index', compact('orders', 'enAttente', 'expedie', 'livre', 'ordersPerMonth', 'statusCounts'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $order->status = $request->status;
        $order->save();

        Cache::forget('order.' . $order->id);
        Cache::forget('orders.user.' . $order->user_id);
        Cache::forget('dashboard.stats'); // Invalidation du cache du tableau de bord

        if ($order->user) {
            $order->user->notify(new OrderStatusUpdatedNotification($order));
        }

        User::role('admin')->get()->each(function($admin) use ($order) {
            $admin->notify(new OrderStatusUpdatedNotification($order));
        });

        event(new OrderStatusUpdated($order));

        return redirect()->back()
            ->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function showUserOrders($userId)
    {
        $this->authorizeAdmin();

        if (!is_numeric($userId)) {
            abort(404);
        }

        $orders = Order::where('user_id', $userId)->get();
        return view('admin.users.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $cacheKey = 'order.' . $order->id;
        
        $order = Cache::remember($cacheKey, 3600, function () use ($order) {
            return $order->load(['products', 'user']);
        });
        
        $livreurs = User::role('livreur')->get();
    
        $storeLat = config('app.store_lat');
        $storeLng = config('app.store_lng');
    
        if ($order->latitude && $order->longitude) {
            $distance = $this->calculateDistance($storeLat, $storeLng, $order->latitude, $order->longitude);
    
            $order->distance_km = round($distance, 1);
            $order->estimated_time_min = ceil($distance * 2);
        }
    
        $promoUsage = PromoUsage::where('order_id', $order->id)->first();
    
        return view('orders.show', compact('order', 'livreurs', 'promoUsage'));
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
    
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }
        
        $total = array_reduce($cart, fn($carry, $item) =>
            $carry + ($item['price'] * $item['quantity']), 0);
            
        return view('orders.checkout', compact('cart', 'total'));
    }

    public function exportPdf()
    {
        $this->authorizeAdmin();

        $orders = Order::whereDate('created_at', today())->with(['user', 'products'])->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_price');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $statusStats = $orders->groupBy('status')->map(function ($group, $status) {
            return [
                'name' => $status,
                'count' => $group->count(),
                'revenue' => $group->sum('total_price'),
            ];
        })->values();

        $dailyStats = collect(range(6, 0))->map(function ($daysAgo) {
            $day = now()->subDays($daysAgo)->format('D');
            $revenue = Order::whereDate('created_at', now()->subDays($daysAgo))->sum('total_price');
            return [
                'day' => $day,
                'revenue' => $revenue,
            ];
        });

        $maxRevenue = $dailyStats->max('revenue');

        $pdf = Pdf::loadView('pdf.orders_daily', [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'averageOrderValue' => $averageOrderValue,
            'dailyStats' => $dailyStats,
            'maxRevenue' => $maxRevenue > 0 ? $maxRevenue : 1,
            'statusStats' => $statusStats,
        ]);

        return $pdf->download('rapport_commandes_' . now()->format('Y-m-d') . '.pdf');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function assignLivreur(Request $request, Order $order)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    
        $request->validate([
            'livreur_id' => 'required|exists:users,id',
        ]);
    
        $livreur = User::findOrFail($request->livreur_id);
    
        $order->livreur_id = $livreur->id;
        $order->save();
    
        Mail::to($livreur->email)->send(new CommandAssignedToLivreur($order, $livreur));
    
        $livreur->notify(new \App\Notifications\CommandeAssignee($order));
    
        return redirect()->back()->with('success', 'Le livreur a bien été assigné à la commande.');
    }

    public function livreurCommandes()
    {
        if (!auth()->user()->hasRole('livreur')) {
            abort(403);
        }

        $userId = auth()->id();
        $query = Order::where('livreur_id', $userId);
        $orders = $query->latest()->get();

        $todayOrders = $orders->filter(function ($order) {
            return $order->created_at->isToday();
        });

        $pendingOrders = $orders->filter(function ($order) {
            return $order->status === 'en attente';
        });

        $deliveredOrders = $orders->filter(function ($order) {
            return $order->status === 'livré';
        });

        // Comptage des statuts pour le graphique
        $statusCounts = [
            'En attente' => $pendingOrders->count(),
            'Livré' => $deliveredOrders->count(),
        ];

        return view('livreurs.orders.index', compact('orders', 'todayOrders', 'pendingOrders', 'deliveredOrders', 'statusCounts'));
    }

    public function markAsDelivered(Order $order)
    {
        if (!auth()->user()->hasRole('livreur') || $order->livreur_id !== auth()->id()) {
            abort(403);
        }

        $order->status = 'livré';
        $order->save();

        Cache::forget('order.' . $order->id);
        Cache::forget('orders.user.' . $order->user_id);
        Cache::forget('dashboard.stats'); // Invalidation du cache du tableau de bord

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\OrderDeliveredByLivreur($order));
        }

        return back()->with('success', 'Commande marquée comme livrée.');
    }

    public function updateDeliveryNotes(Request $request, Order $order)
    {
        $request->validate([
            'delivery_notes' => 'nullable|string|max:255',
        ]);

        $order->delivery_notes = $request->input('delivery_notes');
        $order->save();

        Cache::forget('order.' . $order->id);
        Cache::forget('dashboard.stats'); // Invalidation du cache du tableau de bord

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Les notes de livraison ont été mises à jour.');
    }

    public function completeDelivery($id)
    {
        $order = Order::findOrFail($id);
        $order->status = Order::STATUS_DELIVERED; // ou un autre statut selon ta logique
        $order->save();

        return redirect()->back()->with('success', 'Commande complétée avec succès.');
    }
    public function completeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $originalTotal = 0;
        foreach ($cart as $item) {
            $originalTotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        $promo = session()->get('promo');
        $discountAmount = 0;
        $finalTotal = $originalTotal;

        if ($promo) {
            $discountAmount = $originalTotal * ($promo['value'] / 100);
            $finalTotal = $originalTotal - $discountAmount;
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $finalTotal,
            'original_price' => $originalTotal,
            'phone_number' => $request->phone_number,
            'payment_method' => $request->payment_method,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'delivery_address' => $request->delivery_address,
        ]);

        Log::info('Commande complétée', ['order_id' => $order->id, 'user_id' => auth()->id()]);

        if ($promo) {
            PromoUsage::create([
                'user_id' => auth()->id(),
                'promotion_id' => $promo['id'],
                'order_id' => $order->id,
                'original_amount' => $originalTotal,
                'discount_amount' => $discountAmount,
            ]);
        }

        $this->checkRewardEligibility(auth()->user());

        Cache::forget('orders.user.' . auth()->id());
        Cache::forget('dashboard.stats'); // Invalidation du cache du tableau de bord
        session()->forget(['cart', 'promo']);

        return redirect()->route('orders.thankyou', ['order' => $order->id]);
    }

    private function recordPromoUsage($order, $promo)
    {
        PromoUsage::create([
            'user_id' => auth()->id(),
            'promotion_id' => $promo['id'],
            'order_id' => $order->id,
            'original_amount' => $order->total_price + ($order->discount ?? 0),
            'discount_amount' => ($promo['value'] / 100) * ($order->total_price + ($order->discount ?? 0)),
        ]);
    }

    private function checkRewardEligibility($user)
    {
        $count = $user->orders()
            ->where('total_price', '>=', 5000)
            ->where('status', '!=', 'annulée')
            ->count();

        if ($count >= 5 && !$user->eligible_for_reward) {
            $user->eligible_for_reward = true;
            $user->save();

            Mail::to($user->email)->send(new \App\Mail\RewardUnlockedMail($user));
        }
    }

    public function adminShow(Order $order)
    {
        $order->load(['user', 'products', 'promoUsage.promotion']);
        
        return view('admin.orders.show', [
            'order' => $order,
            'livreurs' => User::role('livreur')->get()
        ]);
    }
}