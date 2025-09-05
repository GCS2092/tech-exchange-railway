<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'page_name',
        'ip_address',
        'user_agent',
        'referer',
        'session_id',
        'user_id',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'duration',
        'is_bounce',
    ];

    protected $casts = [
        'is_bounce' => 'boolean',
        'duration' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les visites d'aujourd'hui
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope pour les visites de cette semaine
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope pour les visites de ce mois
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Scope pour les visites uniques (par IP)
     */
    public function scopeUniqueVisitors($query)
    {
        return $query->select('ip_address')->distinct();
    }

    /**
     * Scope pour les visites de pages spécifiques
     */
    public function scopeForPage($query, $pageName)
    {
        return $query->where('page_name', $pageName);
    }

    /**
     * Obtenir les statistiques de visites
     */
    public static function getVisitStats($period = 'today')
    {
        $baseQuery = self::query();

        switch ($period) {
            case 'today':
                $baseQuery->today();
                break;
            case 'week':
                $baseQuery->thisWeek();
                break;
            case 'month':
                $baseQuery->thisMonth();
                break;
        }

        $totalViews = (clone $baseQuery)->count();
        $uniqueVisitors = (clone $baseQuery)->select('ip_address')->distinct()->count();
        $avgDuration = (clone $baseQuery)->whereNotNull('duration')->avg('duration');
        $bounceCount = (clone $baseQuery)->where('is_bounce', true)->count();

        return [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'avg_duration' => $avgDuration ?? 0,
            'bounce_rate' => $totalViews > 0 ? ($bounceCount / $totalViews) * 100 : 0,
        ];
    }

    /**
     * Obtenir les pages les plus visitées
     */
    public static function getTopPages($limit = 10)
    {
        $pages = self::select('page_name', 'url')
            ->selectRaw('COUNT(*) as views')
            ->selectRaw('AVG(CASE WHEN duration IS NOT NULL THEN duration ELSE 0 END) as avg_time')
            ->whereNotNull('page_name')
            ->groupBy('page_name', 'url')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();

        // Ensure each page has the required properties
        return $pages->map(function ($page) {
            $page->views = $page->views ?? 0;
            $page->avg_time = $page->avg_time ? round($page->avg_time / 60, 1) : 0; // Convert to minutes
            return $page;
        });
    }

    /**
     * Obtenir les statistiques par périodes
     */
    public static function getPeriodStats($days = 30)
    {
        $stats = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayStats = self::whereDate('created_at', $date)->get();
            
            $stats[] = [
                'date' => $date->format('Y-m-d'),
                'views' => $dayStats->count(),
                'unique_visitors' => $dayStats->unique('ip_address')->count(),
                'avg_duration' => $dayStats->whereNotNull('duration')->avg('duration') ?? 0,
            ];
        }

        return $stats;
    }

    /**
     * Obtenir les statistiques par appareil
     */
    public static function getDeviceStats()
    {
        return self::select('device_type')
            ->selectRaw('COUNT(*) as count')
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Obtenir les statistiques par navigateur
     */
    public static function getBrowserStats()
    {
        return self::select('browser')
            ->selectRaw('COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
    }
}
