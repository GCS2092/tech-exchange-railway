<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use App\Models\PageView;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Afficher le dashboard analytics
     */
    public function index()
    {
        $stats = $this->analyticsService->getVisitStatistics();
        $performanceStats = $this->analyticsService->getPerformanceStats();
        $trends = $this->analyticsService->getVisitTrends(30);

        return view('admin.analytics.index', compact('stats', 'performanceStats', 'trends'));
    }

    /**
     * Afficher les pages les plus visitées
     */
    public function topPages()
    {
        $topPages = PageView::getTopPages(20);
        $deviceStats = PageView::getDeviceStats();
        $browserStats = PageView::getBrowserStats();
        
        // Calculer le total des vues avec sécurité
        $totalViews = $topPages && $topPages->count() > 0 ? $topPages->sum('views') : 0;
        $totalUsers = PageView::distinct('ip_address')->count();

        return view('admin.analytics.top-pages', compact('topPages', 'deviceStats', 'browserStats', 'totalViews', 'totalUsers'));
    }

    /**
     * Afficher les statistiques par période
     */
    public function periodStats(Request $request)
    {
        $days = $request->get('days', 30);
        $periodStats = PageView::getPeriodStats($days);

        return view('admin.analytics.period-stats', compact('periodStats', 'days'));
    }

    /**
     * Afficher les statistiques en temps réel
     */
    public function realTime()
    {
        // Visites des dernières 24h
        $last24h = PageView::where('created_at', '>=', now()->subDay())->get();
        
        // Visites par heure
        $hourlyStats = [];
        for ($i = 23; $i >= 0; $i--) {
            $hour = now()->subHours($i);
            $count = PageView::whereBetween('created_at', [
                $hour->startOfHour(),
                $hour->endOfHour()
            ])->count();
            
            $hourlyStats[] = [
                'hour' => $hour->format('H:00'),
                'count' => $count,
            ];
        }

        // Visiteurs actifs (dernières 5 minutes)
        $activeVisitors = PageView::where('created_at', '>=', now()->subMinutes(5))
            ->distinct('ip_address')
            ->count();

        return view('admin.analytics.real-time', compact('last24h', 'hourlyStats', 'activeVisitors'));
    }

    /**
     * Exporter les données analytics
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $period = $request->get('period', 'month');
        
        $stats = $this->analyticsService->getVisitStatistics();
        
        if ($format === 'json') {
            return response()->json($stats);
        }
        
        // Export CSV
        $filename = "analytics-{$period}-" . now()->format('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        
        $callback = function() use ($stats) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, ['Période', 'Vues totales', 'Visiteurs uniques', 'Durée moyenne', 'Taux de rebond']);
            
            // Données
            foreach (['today', 'this_week', 'this_month'] as $period) {
                $data = $stats[$period];
                fputcsv($file, [
                    ucfirst(str_replace('_', ' ', $period)),
                    $data['total_views'],
                    $data['unique_visitors'],
                    round($data['avg_duration'] ?? 0) . 's',
                    round($data['bounce_rate'], 1) . '%'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * API pour les données analytics (AJAX)
     */
    public function api(Request $request)
    {
        $type = $request->get('type', 'overview');
        
        switch ($type) {
            case 'overview':
                return response()->json($this->analyticsService->getDashboardStats());
            
            case 'trends':
                $days = $request->get('days', 7);
                return response()->json($this->analyticsService->getVisitTrends($days));
            
            case 'top_pages':
                return response()->json(PageView::getTopPages(10));
            
            case 'device_stats':
                return response()->json(PageView::getDeviceStats());
            
            case 'browser_stats':
                return response()->json(PageView::getBrowserStats());
            
            default:
                return response()->json(['error' => 'Type non reconnu'], 400);
        }
    }
}
