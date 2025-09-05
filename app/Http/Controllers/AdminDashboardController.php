<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\TradeOffer;
use App\Models\Category;
use App\Models\Promotion;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class AdminDashboardController extends Controller
{


    public function index()
    {
        // Période actuelle
        $currentMonth = Carbon::now()->startOfMonth();
        $currentYear = Carbon::now()->startOfYear();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // Statistiques générales
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_trades' => TradeOffer::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
        ];

        // Statistiques du mois en cours
        $monthlyStats = [
            'new_users' => User::where('created_at', '>=', $currentMonth)->count(),
            'new_orders' => Order::where('created_at', '>=', $currentMonth)->count(),
            'completed_orders' => Order::where('status', 'completed')
                ->where('created_at', '>=', $currentMonth)->count(),
            'monthly_revenue' => Order::where('status', 'completed')
                ->where('created_at', '>=', $currentMonth)->sum('total_price'),
            'new_trades' => TradeOffer::where('created_at', '>=', $currentMonth)->count(),
            'accepted_trades' => TradeOffer::where('status', 'accepted')
                ->where('created_at', '>=', $currentMonth)->count(),
        ];

        // Comparaison avec le mois précédent
        $lastMonthStats = [
            'new_users' => User::whereBetween('created_at', [$lastMonth, $currentMonth])->count(),
            'new_orders' => Order::whereBetween('created_at', [$lastMonth, $currentMonth])->count(),
            'monthly_revenue' => Order::where('status', 'completed')
                ->whereBetween('created_at', [$lastMonth, $currentMonth])->sum('total_price'),
        ];

        // Évolution des utilisateurs par mois (6 derniers mois)
        $userEvolution = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $userEvolution[] = [
                'month' => $month->format('M Y'),
                'users' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->count(),
            ];
        }

        // Répartition des utilisateurs par rôle
        $usersByRole = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(*) as count'))
            ->groupBy('roles.name')
            ->get();

        // Top 5 des produits les plus vendus
        $topProducts = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_product.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Répartition des commandes par statut
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Répartition des trocs par type d'appareil
        $tradesByDeviceType = TradeOffer::join('products', 'trade_offers.product_id', '=', 'products.id')
            ->select('products.device_type', DB::raw('count(*) as count'))
            ->groupBy('products.device_type')
            ->get();

        // Stock disponible par catégorie
        $stockByCategory = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(products.quantity) as total_stock'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Commandes récentes
        $recentOrders = Order::with(['user', 'products'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Troc récents
        $recentTrades = TradeOffer::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Statistiques des codes promos
        $promoStats = [
            'total_promos' => Promotion::count(),
            'active_promos' => Promotion::where('is_active', true)->count(),
            'total_usage' => Promotion::sum('uses_count'),
        ];

        // Statistiques de visites réelles
        $analyticsService = new \App\Services\AnalyticsService();
        $visitStats = $analyticsService->getDashboardStats();
        
        $visits = [
            'today' => $visitStats['today']['views'],
            'this_week' => $visitStats['this_week']['views'],
            'this_month' => $visitStats['this_month']['views'],
            'unique_today' => $visitStats['today']['unique_visitors'],
            'unique_week' => $visitStats['this_week']['unique_visitors'],
            'unique_month' => $visitStats['this_month']['unique_visitors'],
            'avg_duration' => $visitStats['today']['avg_duration'],
            'bounce_rate' => $visitStats['today']['bounce_rate'],
        ];

        return view('admin.dashboard-advanced', compact(
            'stats',
            'monthlyStats',
            'lastMonthStats',
            'userEvolution',
            'usersByRole',
            'topProducts',
            'ordersByStatus',
            'tradesByDeviceType',
            'stockByCategory',
            'recentOrders',
            'recentTrades',
            'promoStats',
            'visits'
        ));
    }

    public function exportPDF()
    {
        // Récupérer les mêmes données que pour l'affichage
        $currentMonth = Carbon::now()->startOfMonth();
        
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_trades' => TradeOffer::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
        ];

        $monthlyStats = [
            'new_users' => User::where('created_at', '>=', $currentMonth)->count(),
            'new_orders' => Order::where('created_at', '>=', $currentMonth)->count(),
            'completed_orders' => Order::where('status', 'completed')
                ->where('created_at', '>=', $currentMonth)->count(),
            'monthly_revenue' => Order::where('status', 'completed')
                ->where('created_at', '>=', $currentMonth)->sum('total_price'),
            'new_trades' => TradeOffer::where('created_at', '>=', $currentMonth)->count(),
        ];

        $pdf = PDF::loadView('admin.reports.dashboard-pdf', compact('stats', 'monthlyStats'));
        
        return $pdf->download('dashboard-rapport-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        // Vérifier si le package Excel est installé
        if (!class_exists('Maatwebsite\Excel\Facades\Excel')) {
            return redirect()->back()->with('error', 'Le package Excel n\'est pas installé');
        }

        $currentMonth = Carbon::now()->startOfMonth();
        
        $data = [
            'stats' => [
                'total_users' => User::count(),
                'total_products' => Product::count(),
                'total_orders' => Order::count(),
                'total_trades' => TradeOffer::count(),
                'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            ],
            'monthly_stats' => [
                'new_users' => User::where('created_at', '>=', $currentMonth)->count(),
                'new_orders' => Order::where('created_at', '>=', $currentMonth)->count(),
                'completed_orders' => Order::where('status', 'completed')
                    ->where('created_at', '>=', $currentMonth)->count(),
                'monthly_revenue' => Order::where('status', 'completed')
                    ->where('created_at', '>=', $currentMonth)->sum('total_price'),
                'new_trades' => TradeOffer::where('created_at', '>=', $currentMonth)->count(),
            ],
        ];

        return Excel::download(new \App\Exports\DashboardExport($data), 'dashboard-rapport-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
} 