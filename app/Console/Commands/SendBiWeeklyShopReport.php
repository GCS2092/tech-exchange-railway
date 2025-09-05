<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\BiWeeklyShopReportMail;
use Carbon\Carbon;

class SendBiWeeklyShopReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:biweekly-shop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer un rapport bimensuel complet de l\'état de la boutique aux administrateurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Génération du rapport bimensuel de la boutique...');

        // Période des 14 derniers jours
        $startDate = Carbon::now()->subDays(14);
        $endDate = Carbon::now();

        // Statistiques des stocks
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'))
            ->where('is_active', true)
            ->count();
        $outOfStockProducts = Product::where('quantity', 0)->where('is_active', true)->count();

        // Statistiques des commandes (14 derniers jours)
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'livré')->count();
        $pendingOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['en attente', 'en préparation', 'en livraison'])->count();
        $cancelledOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'annulé')->count();

        // Revenus (14 derniers jours)
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'livré')
            ->sum('total_price');

        // Statistiques des utilisateurs
        $totalUsers = User::count();
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $activeUsers = User::whereHas('orders', function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->count();

        // Top 5 des produits les plus vendus
        $topProducts = Product::withCount(['orderItems as total_sold' => function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->where('status', 'livré');
            });
        }])
        ->orderBy('total_sold', 'desc')
        ->limit(5)
        ->get();

        // Top 5 des catégories les plus vendues
        $topCategories = Category::withCount(['products as total_sold' => function($query) use ($startDate, $endDate) {
            $query->whereHas('orderItems.order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->where('status', 'livré');
            });
        }])
        ->orderBy('total_sold', 'desc')
        ->limit(5)
        ->get();

        // Produits en stock faible
        $lowStockProductsList = Product::with(['category', 'seller'])
            ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'))
            ->where('is_active', true)
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();

        // Données du rapport
        $reportData = [
            'period' => [
                'start' => $startDate->format('d/m/Y'),
                'end' => $endDate->format('d/m/Y'),
                'days' => 14
            ],
            'stocks' => [
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
                'low_stock_count' => $lowStockProducts,
                'out_of_stock_count' => $outOfStockProducts,
                'low_stock_products' => $lowStockProductsList
            ],
            'orders' => [
                'total' => $totalOrders,
                'completed' => $completedOrders,
                'pending' => $pendingOrders,
                'cancelled' => $cancelledOrders,
                'completion_rate' => $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'average_per_order' => $completedOrders > 0 ? round($totalRevenue / $completedOrders, 0) : 0
            ],
            'users' => [
                'total' => $totalUsers,
                'new' => $newUsers,
                'active' => $activeUsers
            ],
            'top_products' => $topProducts,
            'top_categories' => $topCategories
        ];

        // Récupérer tous les administrateurs
        $admins = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        if ($admins->isEmpty()) {
            $this->error('Aucun administrateur trouvé.');
            return 1;
        }

        // Envoyer le rapport à chaque administrateur
        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(new BiWeeklyShopReportMail($reportData, $admin));
                $this->info("Rapport bimensuel envoyé à {$admin->email}");
            } catch (\Exception $e) {
                $this->error("Erreur lors de l'envoi à {$admin->email}: " . $e->getMessage());
            }
        }

        $this->info('Rapport bimensuel de la boutique envoyé avec succès !');
        return 0;
    }
}