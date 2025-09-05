<?php

namespace App\Services;

use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class AnalyticsService
{
    /**
     * Enregistrer une visite de page à partir de données extraites
     */
    public function trackPageViewFromData(array $trackingData, $pageName = null, $duration = null)
    {
        try {
            $agent = new Agent();
            $agent->setUserAgent($trackingData['user_agent']);
            
            // Détecter le type d'appareil
            $deviceType = 'desktop';
            if ($agent->isTablet()) {
                $deviceType = 'tablet';
            } elseif ($agent->isMobile()) {
                $deviceType = 'mobile';
            }

            // Détecter le navigateur et l'OS
            $browser = $agent->browser();
            $os = $agent->platform();

            // Créer l'enregistrement de visite
            $pageView = PageView::create([
                'url' => $trackingData['url'],
                'page_name' => $pageName ?? $this->getPageNameFromUrl($trackingData['path']),
                'ip_address' => $trackingData['ip_address'],
                'user_agent' => $trackingData['user_agent'],
                'referer' => $trackingData['referer'],
                'session_id' => $trackingData['session_id'],
                'user_id' => $trackingData['user_id'],
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'duration' => $duration,
                'is_bounce' => $this->isBounceFromData($trackingData),
            ]);

            // Mettre à jour le taux de rebond si ce n'est pas la première visite de la session
            if (!$this->isBounceFromData($trackingData)) {
                $this->updateBounceRate($trackingData['session_id']);
            }

            Log::info('Page view tracked', [
                'url' => $pageView->url,
                'page_name' => $pageView->page_name,
                'user_id' => $pageView->user_id,
                'ip' => $pageView->ip_address,
            ]);

            return $pageView;

        } catch (\Exception $e) {
            Log::error('Error tracking page view: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Enregistrer une visite de page
     */
    public function trackPageView(Request $request, $pageName = null, $duration = null)
    {
        try {
            $agent = new Agent();
            
            // Détecter le type d'appareil
            $deviceType = 'desktop';
            if ($agent->isTablet()) {
                $deviceType = 'tablet';
            } elseif ($agent->isMobile()) {
                $deviceType = 'mobile';
            }

            // Détecter le navigateur et l'OS
            $browser = $agent->browser();
            $os = $agent->platform();

            // Créer l'enregistrement de visite
            $pageView = PageView::create([
                'url' => $request->fullUrl(),
                'page_name' => $pageName ?? $this->getPageNameFromUrl($request->path()),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'session_id' => $request->session()->getId(),
                'user_id' => auth()->id(),
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'duration' => $duration,
                'is_bounce' => $this->isBounce($request),
            ]);

            // Mettre à jour le taux de rebond si ce n'est pas la première visite de la session
            if (!$this->isBounce($request)) {
                $this->updateBounceRate($request->session()->getId());
            }

            Log::info('Page view tracked', [
                'url' => $pageView->url,
                'page_name' => $pageView->page_name,
                'user_id' => $pageView->user_id,
                'ip' => $pageView->ip_address,
            ]);

            return $pageView;

        } catch (\Exception $e) {
            Log::error('Error tracking page view: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtenir le nom de la page à partir de l'URL
     */
    private function getPageNameFromUrl($path)
    {
        $pageNames = [
            '/' => 'Accueil',
            'products' => 'Produits',
            'cart' => 'Panier',
            'login' => 'Connexion',
            'register' => 'Inscription',
            'admin/dashboard' => 'Dashboard Admin',
            'admin/users' => 'Gestion Utilisateurs',
            'admin/orders' => 'Gestion Commandes',
            'admin/products' => 'Gestion Produits',
            'vendeur/dashboard' => 'Dashboard Vendeur',
            'livreur/orders' => 'Commandes Livreur',
        ];

        return $pageNames[$path] ?? ucfirst(str_replace(['-', '_'], ' ', $path));
    }

    /**
     * Vérifier si c'est un rebond (première visite de la session)
     */
    private function isBounce(Request $request)
    {
        $sessionId = $request->session()->getId();
        $existingViews = PageView::where('session_id', $sessionId)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count();

        return $existingViews === 0;
    }

    /**
     * Vérifier si c'est un rebond à partir des données de tracking
     */
    private function isBounceFromData(array $trackingData)
    {
        $sessionId = $trackingData['session_id'];
        $existingViews = PageView::where('session_id', $sessionId)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count();

        return $existingViews === 0;
    }

    /**
     * Mettre à jour le taux de rebond pour les visites précédentes de la session
     */
    private function updateBounceRate($sessionId)
    {
        PageView::where('session_id', $sessionId)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->update(['is_bounce' => false]);
    }

    /**
     * Obtenir les statistiques complètes de visites
     */
    public function getVisitStatistics()
    {
        return [
            'today' => PageView::getVisitStats('today'),
            'week' => PageView::getVisitStats('week'),
            'month' => PageView::getVisitStats('month'),
            'top_pages' => PageView::getTopPages(10),
            'device_stats' => PageView::getDeviceStats(),
            'browser_stats' => PageView::getBrowserStats(),
            'period_stats' => PageView::getPeriodStats(30),
        ];
    }

    /**
     * Obtenir les statistiques pour le dashboard admin
     */
    public function getDashboardStats()
    {
        $todayStats = PageView::getVisitStats('today');
        $weekStats = PageView::getVisitStats('week');
        $monthStats = PageView::getVisitStats('month');

        return [
            'today' => [
                'views' => $todayStats['total_views'],
                'unique_visitors' => $todayStats['unique_visitors'],
                'avg_duration' => round($todayStats['avg_duration'] ?? 0),
                'bounce_rate' => round($todayStats['bounce_rate'], 1),
            ],
            'this_week' => [
                'views' => $weekStats['total_views'],
                'unique_visitors' => $weekStats['unique_visitors'],
                'avg_duration' => round($weekStats['avg_duration'] ?? 0),
                'bounce_rate' => round($weekStats['bounce_rate'], 1),
            ],
            'this_month' => [
                'views' => $monthStats['total_views'],
                'unique_visitors' => $monthStats['unique_visitors'],
                'avg_duration' => round($monthStats['avg_duration'] ?? 0),
                'bounce_rate' => round($monthStats['bounce_rate'], 1),
            ],
        ];
    }

    /**
     * Obtenir les tendances de visites
     */
    public function getVisitTrends($days = 7)
    {
        $trends = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayStats = PageView::whereDate('created_at', $date)->get();
            
            $trends[] = [
                'date' => $date->format('d/m'),
                'views' => $dayStats->count(),
                'unique_visitors' => $dayStats->unique('ip_address')->count(),
            ];
        }

        return $trends;
    }

    /**
     * Obtenir les statistiques de performance
     */
    public function getPerformanceStats()
    {
        $monthlyStats = PageView::getVisitStats('month');
        
        return [
            'total_page_views' => PageView::count(),
            'total_unique_visitors' => PageView::select('ip_address')->distinct()->count(),
            'avg_session_duration' => round($monthlyStats['avg_duration'] ?? 0),
            'bounce_rate' => round($monthlyStats['bounce_rate'], 1),
            'pages_per_session' => $this->calculatePagesPerSession(),
        ];
    }

    /**
     * Calculer le nombre moyen de pages par session
     */
    private function calculatePagesPerSession()
    {
        $totalViews = PageView::count();
        $uniqueSessions = PageView::select('session_id')->distinct()->count();
        
        return $uniqueSessions > 0 ? round($totalViews / $uniqueSessions, 2) : 0;
    }
}
