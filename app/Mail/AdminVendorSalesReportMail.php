<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminVendorSalesReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $period;
    public $reportType; // 'daily', 'weekly', 'monthly'
    public $allVendorsData;
    public $summaryData;

    /**
     * Create a new message instance.
     */
    public function __construct(User $admin, string $reportType = 'daily', $period = null)
    {
        $this->admin = $admin;
        $this->reportType = $reportType;
        $this->period = $period ?? $this->getDefaultPeriod($reportType);
        $this->allVendorsData = $this->generateAllVendorsData();
        $this->summaryData = $this->generateSummaryData();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $icons = [
            'daily' => '📊',
            'weekly' => '📈',
            'monthly' => '📋',
        ];

        $icon = $icons[$this->reportType] ?? '📊';
        
        return new Envelope(
            subject: $icon . ' RAPPORT VENTES VENDEURS ' . strtoupper($this->reportType) . ' - ' . $this->period['label'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.admin.vendor-sales-report', [
                'admin' => $this->admin,
                'period' => $this->period,
                'reportType' => $this->reportType,
                'allVendorsData' => $this->allVendorsData,
                'summaryData' => $this->summaryData,
            ])->render(),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Obtenir la période par défaut selon le type de rapport
     */
    private function getDefaultPeriod($reportType)
    {
        switch ($reportType) {
            case 'daily':
                return [
                    'start' => now()->startOfDay(),
                    'end' => now()->endOfDay(),
                    'label' => now()->format('d/m/Y'),
                ];
            case 'weekly':
                return [
                    'start' => now()->startOfWeek(),
                    'end' => now()->endOfWeek(),
                    'label' => now()->startOfWeek()->format('d/m/Y') . ' - ' . now()->endOfWeek()->format('d/m/Y'),
                ];
            case 'monthly':
                return [
                    'start' => now()->startOfMonth(),
                    'end' => now()->endOfMonth(),
                    'label' => now()->format('F Y'),
                ];
            default:
                return $this->getDefaultPeriod('daily');
        }
    }

    /**
     * Générer les données de tous les vendeurs
     */
    private function generateAllVendorsData()
    {
        $start = $this->period['start'];
        $end = $this->period['end'];

        // Récupérer tous les vendeurs
        $vendors = User::role('vendeur')->get();
        $vendorsData = [];

        foreach ($vendors as $vendor) {
            // Commandes contenant des produits du vendeur
            $orders = Order::whereHas('products', function($query) use ($vendor) {
                $query->where('seller_id', $vendor->id);
            })
            ->whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'annulée')
            ->with(['products' => function($query) use ($vendor) {
                $query->where('seller_id', $vendor->id);
            }, 'user'])
            ->get();

            // Calculer les statistiques
            $totalOrders = $orders->count();
            $totalRevenue = 0;
            $totalProducts = 0;
            $topProducts = collect();
            $productStats = [];

            foreach ($orders as $order) {
                foreach ($order->products as $product) {
                    $quantity = $product->pivot->quantity ?? 1;
                    $price = $product->pivot->price ?? $product->price;
                    $revenue = $quantity * $price;
                    
                    $totalRevenue += $revenue;
                    $totalProducts += $quantity;

                    // Statistiques par produit
                    if (!isset($productStats[$product->id])) {
                        $productStats[$product->id] = [
                            'product' => $product,
                            'quantity_sold' => 0,
                            'revenue' => 0,
                            'orders_count' => 0,
                        ];
                    }
                    
                    $productStats[$product->id]['quantity_sold'] += $quantity;
                    $productStats[$product->id]['revenue'] += $revenue;
                    $productStats[$product->id]['orders_count']++;
                }
            }

            // Top produits
            $topProducts = collect($productStats)
                ->sortByDesc('revenue')
                ->take(3);

            // Comparaison avec la période précédente
            $previousPeriod = $this->getPreviousPeriod();
            $previousOrders = Order::whereHas('products', function($query) use ($vendor) {
                $query->where('seller_id', $vendor->id);
            })
            ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
            ->where('status', '!=', 'annulée')
            ->count();

            $previousRevenue = Order::whereHas('products', function($query) use ($vendor) {
                $query->where('seller_id', $vendor->id);
            })
            ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
            ->where('status', '!=', 'annulée')
            ->with(['products' => function($query) use ($vendor) {
                $query->where('seller_id', $vendor->id);
            }])
            ->get()
            ->sum(function($order) {
                return $order->products->sum(function($product) {
                    $quantity = $product->pivot->quantity ?? 1;
                    $price = $product->pivot->price ?? $product->price;
                    return $quantity * $price;
                });
            });

            $ordersGrowth = $previousOrders > 0 ? (($totalOrders - $previousOrders) / $previousOrders) * 100 : 0;
            $revenueGrowth = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;

            $vendorsData[] = [
                'vendor' => $vendor,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_products_sold' => $totalProducts,
                'top_products' => $topProducts,
                'orders_growth' => $ordersGrowth,
                'revenue_growth' => $revenueGrowth,
                'product_stats' => $productStats,
            ];
        }

        // Trier par chiffre d'affaires décroissant
        return collect($vendorsData)->sortByDesc('total_revenue')->values();
    }

    /**
     * Générer les données de résumé global
     */
    private function generateSummaryData()
    {
        $start = $this->period['start'];
        $end = $this->period['end'];

        // Statistiques globales
        $totalOrders = Order::whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'annulée')
            ->count();

        $totalRevenue = Order::whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'annulée')
            ->sum('total_price');

        $totalProducts = Order::whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'annulée')
            ->with('products')
            ->get()
            ->sum(function($order) {
                return $order->products->sum('pivot.quantity');
            });

        // Top vendeurs
        $topVendors = collect($this->allVendorsData)
            ->take(5);

        // Top produits globaux
        $topProducts = Product::whereHas('orders', function($query) use ($start, $end) {
            $query->whereBetween('orders.created_at', [$start, $end])
                ->where('orders.status', '!=', 'annulée');
        })
        ->with(['orders' => function($query) use ($start, $end) {
            $query->whereBetween('orders.created_at', [$start, $end])
                ->where('orders.status', '!=', 'annulée');
        }])
        ->get()
        ->map(function($product) {
            $totalSold = $product->orders->sum('pivot.quantity');
            $totalRevenue = $product->orders->sum(function($order) {
                return $order->pivot->quantity * $order->pivot->price;
            });
            
            return [
                'product' => $product,
                'quantity_sold' => $totalSold,
                'revenue' => $totalRevenue,
            ];
        })
        ->sortByDesc('revenue')
        ->take(5);

        // Comparaison avec la période précédente
        $previousPeriod = $this->getPreviousPeriod();
        $previousOrders = Order::whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
            ->where('status', '!=', 'annulée')
            ->count();

        $previousRevenue = Order::whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
            ->where('status', '!=', 'annulée')
            ->sum('total_price');

        $ordersGrowth = $previousOrders > 0 ? (($totalOrders - $previousOrders) / $previousOrders) * 100 : 0;
        $revenueGrowth = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_products_sold' => $totalProducts,
            'top_vendors' => $topVendors,
            'top_products' => $topProducts,
            'orders_growth' => $ordersGrowth,
            'revenue_growth' => $revenueGrowth,
            'active_vendors' => collect($this->allVendorsData)->where('total_orders', '>', 0)->count(),
            'total_vendors' => collect($this->allVendorsData)->count(),
        ];
    }

    /**
     * Obtenir la période précédente
     */
    private function getPreviousPeriod()
    {
        switch ($this->reportType) {
            case 'daily':
                return [
                    'start' => now()->subDay()->startOfDay(),
                    'end' => now()->subDay()->endOfDay(),
                    'label' => now()->subDay()->format('d/m/Y'),
                ];
            case 'weekly':
                return [
                    'start' => now()->subWeek()->startOfWeek(),
                    'end' => now()->subWeek()->endOfWeek(),
                    'label' => now()->subWeek()->startOfWeek()->format('d/m/Y') . ' - ' . now()->subWeek()->endOfWeek()->format('d/m/Y'),
                ];
            case 'monthly':
                return [
                    'start' => now()->subMonth()->startOfMonth(),
                    'end' => now()->subMonth()->endOfMonth(),
                    'label' => now()->subMonth()->format('F Y'),
                ];
            default:
                return $this->getPreviousPeriod();
        }
    }
}
