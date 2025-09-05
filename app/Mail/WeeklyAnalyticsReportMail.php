<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\PageView;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class WeeklyAnalyticsReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $analytics;

    /**
     * Create a new message instance.
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
        $this->analytics = $this->generateAnalytics();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📈 RAPPORT HEBDOMADAIRE - Analytics et Performance',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.admin.weekly-analytics-report', [
                'admin' => $this->admin,
                'analytics' => $this->analytics,
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
     * Générer les analytics de la semaine
     */
    private function generateAnalytics()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();

        // Visites
        $currentWeekVisits = PageView::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $lastWeekVisits = PageView::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        $visitsGrowth = $lastWeekVisits > 0 ? (($currentWeekVisits - $lastWeekVisits) / $lastWeekVisits) * 100 : 0;

        // Commandes
        $currentWeekOrders = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $lastWeekOrders = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        $ordersGrowth = $lastWeekOrders > 0 ? (($currentWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100 : 0;

        // Chiffre d'affaires
        $currentWeekRevenue = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status', '!=', 'annulée')
            ->sum('total_price');
        $lastWeekRevenue = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->where('status', '!=', 'annulée')
            ->sum('total_price');
        $revenueGrowth = $lastWeekRevenue > 0 ? (($currentWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100 : 0;

        // Nouveaux utilisateurs
        $currentWeekUsers = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $lastWeekUsers = User::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        $usersGrowth = $lastWeekUsers > 0 ? (($currentWeekUsers - $lastWeekUsers) / $lastWeekUsers) * 100 : 0;

        // Pages les plus visitées
        $topPages = PageView::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('page_name, COUNT(*) as visits')
            ->groupBy('page_name')
            ->orderBy('visits', 'desc')
            ->limit(5)
            ->get();

        // Produits les plus vendus
        $topProducts = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status', '!=', 'annulée')
            ->with('products')
            ->get()
            ->flatMap(function ($order) {
                return $order->products;
            })
            ->groupBy('id')
            ->map(function ($products) {
                return [
                    'product' => $products->first(),
                    'quantity' => $products->sum('pivot.quantity'),
                ];
            })
            ->sortByDesc('quantity')
            ->take(5);

        return [
            'period' => [
                'current' => $startOfWeek->format('d/m/Y') . ' - ' . $endOfWeek->format('d/m/Y'),
                'previous' => $lastWeekStart->format('d/m/Y') . ' - ' . $lastWeekEnd->format('d/m/Y'),
            ],
            'visits' => [
                'current' => $currentWeekVisits,
                'previous' => $lastWeekVisits,
                'growth' => $visitsGrowth,
            ],
            'orders' => [
                'current' => $currentWeekOrders,
                'previous' => $lastWeekOrders,
                'growth' => $ordersGrowth,
            ],
            'revenue' => [
                'current' => $currentWeekRevenue,
                'previous' => $lastWeekRevenue,
                'growth' => $revenueGrowth,
            ],
            'users' => [
                'current' => $currentWeekUsers,
                'previous' => $lastWeekUsers,
                'growth' => $usersGrowth,
            ],
            'topPages' => $topPages,
            'topProducts' => $topProducts,
        ];
    }
}
