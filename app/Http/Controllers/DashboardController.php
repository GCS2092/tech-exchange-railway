<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ADMIN
        if ($user->hasRole('admin')) {
            $totalUsers = User::count();
            $activeUsers = User::where('active', true)->count();
            $inactiveUsers = $totalUsers - $activeUsers;

            $adminsCount = User::role('admin')->count();
            $clientsCount = User::role('client')->count();
            $vendeursCount = User::role('vendeur')->count();

            $enAttenteCount = Order::where('status', 'en attente')->count();
            $expedieCount = Order::where('status', 'expédié')->count();
            $livreCount = Order::where('status', 'livré')->count();

            $products = Product::with('category')->get();
            $users = User::all(); // Simplifié, car 'roles' n'est pas utilisé dans la vue
            $notifications = $user->unreadNotifications;

            $totalProductsValue = Product::all()->reduce(function($carry, $product) {
                return $carry + ($product->price * $product->quantity);
            }, 0);

            // Récupération directe sans cache
            $stats = [
                'total_orders' => Order::count(),
                'total_revenue' => Order::where('status', '!=', 'annulé')->sum('total_price'),
                'total_products' => Product::count(),
                'total_users' => User::count(),
                'recent_orders' => Order::with(['user', 'products'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'top_products' => Product::select('products.*')
                    ->join(DB::raw('(SELECT product_id, COUNT(*) as order_count 
                        FROM order_product 
                        GROUP BY product_id 
                        ORDER BY order_count DESC 
                        LIMIT 5) as top_products'), 
                        'products.id', '=', 'top_products.product_id')
                    ->orderBy('top_products.order_count', 'DESC')
                    ->get()
            ];

            // Log pour déboguer
            Log::info('Commandes récentes pour tableau de bord', [
                'count' => $stats['recent_orders']->count(),
                'orders' => $stats['recent_orders']->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'user_id' => $order->user_id,
                        'user_name' => optional($order->user)->name,
                        'total_price' => $order->total_price,
                        'status' => $order->status,
                        'products_count' => $order->products->count()
                    ];
                })->toArray()
            ]);

            return view('admin.dashboard', compact(
                'totalUsers', 'activeUsers', 'inactiveUsers',
                'adminsCount', 'clientsCount', 'vendeursCount',
                'enAttenteCount', 'expedieCount', 'livreCount',
                'products', 'users', 'notifications', 'stats', 'totalProductsValue'
            ));
        }
        // VENDEUR
        if ($user->hasRole('vendeur')) {
            return redirect()->route('vendeur.dashboard');
        }
        // USER – vue plus simple
        $notifications = $user->unreadNotifications;
        return view('user.dashboard', compact('user', 'notifications'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);
        $user->update($request->only('name', 'email'));
        $user->syncRoles([$request->role]);
        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);
        $user = \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur créé avec succès.');
    }

    public function destroyUser(Request $request, User $user)
    {
        if (Hash::check($request->password, Auth::user()->password)) {
            $user->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Utilisateur supprimé avec succès.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Mot de passe incorrect.');
    }

    public function salesReport()
    {
        // Récupération directe sans cache
        $report = [
            'daily_sales' => Order::whereDate('created_at', today())
                ->where('status', '!=', 'annulé')
                ->sum('total_price'),
            'weekly_sales' => Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->where('status', '!=', 'annulé')
                ->sum('total_price'),
            'monthly_sales' => Order::whereMonth('created_at', now()->month)
                ->where('status', '!=', 'annulé')
                ->sum('total_price')
        ];
        
        Log::info('Rapport des ventes généré', [
            'daily_sales' => $report['daily_sales'],
            'weekly_sales' => $report['weekly_sales'],
            'monthly_sales' => $report['monthly_sales']
        ]);

        return view('dashboard.sales', compact('report'));
    }
}