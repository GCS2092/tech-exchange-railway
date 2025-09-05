<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\TradeOffer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsService
{
    /**
     * Obtient toutes les statistiques du dashboard admin
     */
    public function getAdminDashboardStats(): array
    {
        return [
            'users' => $this->getUserStatistics(),
            'orders' => $this->getOrderStatistics(),
            'products' => $this->getProductStatistics(),
            'revenue' => $this->getRevenueStatistics(),
            'trades' => $this->getTradeStatistics(),
            'inventory' => $this->getInventoryStatistics(),
            'recent_activity' => $this->getRecentActivity(),
            'monthly_trends' => $this->getMonthlyTrends(),
        ];
    }
    
    /**
     * Statistiques des utilisateurs
     */
    public function getUserStatistics(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        
        return [
            'total_users' => User::count(),
            'active_users' => User::where('active', true)->count(),
            'new_users_this_month' => User::where('created_at', '>=', $startOfMonth)->count(),
            'new_users_this_week' => User::where('created_at', '>=', $now->copy()->startOfWeek())->count(),
            'users_by_role' => [
                'admin' => User::role('admin')->count(),
                'vendeur' => User::role('vendeur')->count(),
                'client' => User::role('client')->count(),
                'livreur' => User::role('livreur')->count(),
            ],
            'users_growth' => $this->getUserGrowth(),
        ];
    }
    
    /**
     * Statistiques des commandes
     */
    public function getOrderStatistics(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        
        return [
            'total_orders' => Order::count(),
            'orders_this_month' => Order::where('created_at', '>=', $startOfMonth)->count(),
            'orders_this_week' => Order::where('created_at', '>=', $now->copy()->startOfWeek())->count(),
            'orders_by_status' => [
                'en_attente' => Order::where('status', 'en attente')->count(),
                'expedie' => Order::where('status', 'expédié')->count(),
                'livre' => Order::where('status', 'livré')->count(),
                'annule' => Order::where('status', 'annulé')->count(),
            ],
            'recent_orders' => Order::with(['user', 'products'])
                ->latest()
                ->take(5)
                ->get(),
            'orders_trend' => $this->getOrderTrend(),
        ];
    }
    
    /**
     * Statistiques des produits
     */
    public function getProductStatistics(): array
    {
        return [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'products_by_category' => Category::withCount('products')->get(),
            'top_selling_products' => $this->getTopSellingProducts(),
            'low_stock_products' => Product::where('quantity', '<=', 5)->where('quantity', '>', 0)->count(),
            'out_of_stock_products' => Product::where('quantity', 0)->count(),
        ];
    }
    
    /**
     * Statistiques des revenus
     */
    public function getRevenueStatistics(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfYear = $now->copy()->startOfYear();
        
        return [
            'total_revenue' => Order::where('status', '!=', 'annulé')->sum('total_price'),
            'revenue_this_month' => Order::where('status', '!=', 'annulé')
                ->where('created_at', '>=', $startOfMonth)
                ->sum('total_price'),
            'revenue_this_year' => Order::where('status', '!=', 'annulé')
                ->where('created_at', '>=', $startOfYear)
                ->sum('total_price'),
            'average_order_value' => Order::where('status', '!=', 'annulé')->avg('total_price'),
            'revenue_by_month' => $this->getRevenueByMonth(),
            'revenue_by_category' => $this->getRevenueByCategory(),
        ];
    }
    
    /**
     * Statistiques des échanges (troc)
     */
    public function getTradeStatistics(): array
    {
        return [
            'total_offers' => TradeOffer::count(),
            'pending_offers' => TradeOffer::where('status', 'pending')->count(),
            'accepted_offers' => TradeOffer::where('status', 'accepted')->count(),
            'rejected_offers' => TradeOffer::where('status', 'rejected')->count(),
            'recent_offers' => TradeOffer::with(['user', 'product'])
                ->latest()
                ->take(3)
                ->get(),
            'offers_by_device_type' => $this->getOffersByDeviceType(),
        ];
    }
    
    /**
     * Statistiques de l'inventaire
     */
    public function getInventoryStatistics(): array
    {
        $stockService = new StockService();
        $stockStats = $stockService->getStockStatistics();
        
        return [
            'total_products' => $stockStats['total_products'],
            'in_stock' => $stockStats['in_stock'],
            'out_of_stock' => $stockStats['out_of_stock'],
            'low_stock' => $stockStats['low_stock'],
            'total_value' => $stockStats['total_value'],
            'average_stock' => $stockStats['average_stock'],
            'stock_levels' => $stockStats['products_by_stock_level'],
            'low_stock_products' => $stockService->getLowStockProducts(),
            'out_of_stock_products' => $stockService->getOutOfStockProducts(),
        ];
    }
    
    /**
     * Activité récente
     */
    public function getRecentActivity(): array
    {
        $now = Carbon::now();
        $lastWeek = $now->copy()->subWeek();
        
        return [
            'recent_orders' => Order::with('user')
                ->where('created_at', '>=', $lastWeek)
                ->latest()
                ->take(10)
                ->get(),
            'recent_users' => User::where('created_at', '>=', $lastWeek)
                ->latest()
                ->take(10)
                ->get(),
            'recent_trades' => TradeOffer::with(['user', 'product'])
                ->where('created_at', '>=', $lastWeek)
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
    
    /**
     * Tendances mensuelles
     */
    public function getMonthlyTrends(): array
    {
        $months = [];
        $revenues = [];
        $orders = [];
        $users = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $months[] = $date->format('M Y');
            $revenues[] = Order::where('status', '!=', 'annulé')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('total_price');
            $orders[] = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $users[] = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }
        
        return [
            'months' => $months,
            'revenues' => $revenues,
            'orders' => $orders,
            'users' => $users,
        ];
    }
    
    /**
     * Croissance des utilisateurs
     */
    private function getUserGrowth(): array
    {
        $growth = [];
        for ($i = 3; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $growth[] = [
                'month' => $date->format('M Y'),
                'count' => User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            ];
        }
        return $growth;
    }
    
    /**
     * Tendances des commandes
     */
    private function getOrderTrend(): array
    {
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            
            $trend[] = [
                'date' => $date->format('d/m'),
                'count' => Order::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
            ];
        }
        return $trend;
    }
    
    /**
     * Produits les plus vendus
     */
    private function getTopSellingProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::select('products.*')
            ->join(DB::raw('(SELECT product_id, COUNT(*) as order_count 
                FROM order_product 
                GROUP BY product_id 
                ORDER BY order_count DESC 
                LIMIT 5) as top_products'), 
                'products.id', '=', 'top_products.product_id')
            ->orderBy('top_products.order_count', 'DESC')
            ->get();
    }
    
    /**
     * Revenus par mois
     */
    private function getRevenueByMonth(): array
    {
        $revenues = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $revenues[] = [
                'month' => $date->format('M Y'),
                'revenue' => Order::where('status', '!=', 'annulé')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->sum('total_price'),
            ];
        }
        return $revenues;
    }
    
    /**
     * Revenus par catégorie
     */
    private function getRevenueByCategory(): array
    {
        return Category::withCount('products')
            ->withSum('products', DB::raw('price * quantity'))
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'total_products' => $category->products_count,
                    'total_value' => $category->products_sum_price_quantity ?? 0,
                ];
            })
            ->toArray();
    }
    
    /**
     * Offres par type d'appareil
     */
    private function getOffersByDeviceType(): array
    {
        return TradeOffer::with(['user', 'product'])
            ->join('products', 'trade_offers.product_id', '=', 'products.id')
            ->select('products.device_type', DB::raw('count(*) as count'))
            ->groupBy('products.device_type')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }
}
