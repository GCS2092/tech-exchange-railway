<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\TradeOffer;
use App\Services\StatisticsService;
use App\Services\StockService;
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

        // Redirection basée sur le rôle
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('vendeur')) {
            return redirect()->route('vendeur.dashboard');
        } elseif ($user->hasRole('livreur')) {
            return redirect()->route('livreur.orders.index');
        }

        // Si on arrive ici, c'est un utilisateur normal (client)
        // Affichage du dashboard utilisateur simple
        $notifications = $user->unreadNotifications;
        return view('user.dashboard', compact('user', 'notifications'));
    }

    public function adminDashboard()
    {
        $user = auth()->user();
        
        // Vérifier que l'utilisateur est admin
        if (!$user->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }

        // Utiliser le service de statistiques pour des données précises et en temps réel
        $statisticsService = new StatisticsService();
        $stockService = new StockService();
        $analyticsService = new \App\Services\AnalyticsService();
        
        $stats = $statisticsService->getAdminDashboardStats();
        $visitStats = $analyticsService->getDashboardStats();
        
        // Ajouter les statistiques de visites aux stats générales
        $stats['visits'] = [
            'today' => $visitStats['today']['views'],
            'this_week' => $visitStats['this_week']['views'],
            'this_month' => $visitStats['this_month']['views'],
            'unique_today' => $visitStats['today']['unique_visitors'],
            'unique_week' => $visitStats['this_week']['unique_visitors'],
            'unique_month' => $visitStats['this_month']['unique_visitors'],
            'avg_duration' => $visitStats['today']['avg_duration'],
            'bounce_rate' => $visitStats['today']['bounce_rate'],
        ];
        
        // Données pour la compatibilité avec l'ancien code
        $totalUsers = $stats['users']['total_users'];
        $activeUsers = $stats['users']['active_users'];
        $inactiveUsers = $totalUsers - $activeUsers;
        
        $adminsCount = $stats['users']['users_by_role']['admin'];
        $clientsCount = $stats['users']['users_by_role']['client'];
        $vendeursCount = $stats['users']['users_by_role']['vendeur'];
        
        $enAttenteCount = $stats['orders']['orders_by_status']['en_attente'];
        $expedieCount = $stats['orders']['orders_by_status']['expedie'];
        $livreCount = $stats['orders']['orders_by_status']['livre'];
        
        $products = Product::with('category')->get();
        $users = User::all();
        $notifications = $user->unreadNotifications;
        
        $totalProductsValue = $stats['inventory']['total_value'];

        // Statistiques des codes promos
        $promoStats = [
            'total' => \App\Models\PromoCode::count(),
            'active' => \App\Models\PromoCode::where('is_active', true)->where('expires_at', '>', now())->count(),
            'expired' => \App\Models\PromoCode::where('expires_at', '<', now())->count(),
            'used' => \App\Models\PromoCode::where('usage_count', '>', 0)->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'inactiveUsers',
            'adminsCount', 'clientsCount', 'vendeursCount',
            'enAttenteCount', 'expedieCount', 'livreCount',
            'products', 'users', 'notifications', 'stats', 'totalProductsValue', 'promoStats'
        ));
    }

    public function adminDashboardAdvanced()
    {
        $user = auth()->user();
        
        // Statistiques avancées
        $stats = $this->getAdvancedStats();
        
        // Statistiques des codes promos
        $promoStats = [
            'total' => \App\Models\PromoCode::count(),
            'active' => \App\Models\PromoCode::where('is_active', true)->where('expires_at', '>', now())->count(),
            'expired' => \App\Models\PromoCode::where('expires_at', '<', now())->count(),
            'used' => \App\Models\PromoCode::where('usage_count', '>', 0)->count(),
        ];

        return view('admin.dashboard-advanced', compact('stats', 'promoStats'));
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
        $user = User::create([
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