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

class VendorSalesReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $period;
    public $salesData;
    public $reportType; // 'daily', 'weekly', 'monthly'

    /**
     * Create a new message instance.
     */
    public function __construct(User $vendor, string $reportType = 'daily', $period = null)
    {
        $this->vendor = $vendor;
        $this->reportType = $reportType;
        $this->period = $period ?? $this->getDefaultPeriod($reportType);
        $this->salesData = $this->generateSalesData();
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
            subject: $icon . ' RAPPORT DE VENTES ' . strtoupper($this->reportType) . ' - ' . $this->vendor->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.vendor.sales-report', [
                'vendor' => $this->vendor,
                'period' => $this->period,
                'salesData' => $this->salesData,
                'reportType' => $this->reportType,
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
     * Générer les données de ventes
     */
    private function generateSalesData()
    {
        $start = $this->period['start'];
        $end = $this->period['end'];

        // Commandes contenant des produits du vendeur
        $orders = Order::whereHas('products', function($query) {
            $query->where('seller_id', $this->vendor->id);
        })
        ->whereBetween('created_at', [$start, $end])
        ->where('status', '!=', 'annulée')
        ->with(['products' => function($query) {
            $query->where('seller_id', $this->vendor->id);
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
            ->take(5);

        // Comparaison avec la période précédente
        $previousPeriod = $this->getPreviousPeriod();
        $previousOrders = Order::whereHas('products', function($query) {
            $query->where('seller_id', $this->vendor->id);
        })
        ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
        ->where('status', '!=', 'annulée')
        ->count();

        $previousRevenue = Order::whereHas('products', function($query) {
            $query->where('seller_id', $this->vendor->id);
        })
        ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
        ->where('status', '!=', 'annulée')
        ->with(['products' => function($query) {
            $query->where('seller_id', $this->vendor->id);
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

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_products_sold' => $totalProducts,
            'top_products' => $topProducts,
            'orders_growth' => $ordersGrowth,
            'revenue_growth' => $revenueGrowth,
            'previous_period' => $previousPeriod,
            'product_stats' => $productStats,
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
