<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AnalyticsService;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Ne tracker que les requêtes GET et les pages HTML
        if ($request->isMethod('GET') && $this->shouldTrack($request)) {
            // Extraire les données nécessaires de la requête
            $trackingData = [
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'session_id' => $request->session()->getId(),
                'user_id' => auth()->id(),
                'accept_header' => $request->header('Accept'),
            ];

            // Tracker la visite de manière asynchrone pour ne pas ralentir la réponse
            dispatch(function () use ($trackingData) {
                $this->analyticsService->trackPageViewFromData($trackingData);
            })->afterResponse();
        }

        return $response;
    }

    /**
     * Déterminer si la requête doit être trackée
     */
    private function shouldTrack(Request $request): bool
    {
        // Ne pas tracker les requêtes AJAX, les assets, etc.
        $excludedPaths = [
            'api/',
            'assets/',
            'css/',
            'js/',
            'images/',
            'fonts/',
            'favicon',
            'robots.txt',
            'sitemap',
            'admin/analytics', // Éviter les boucles infinies
        ];

        $path = $request->path();
        
        foreach ($excludedPaths as $excludedPath) {
            if (str_starts_with($path, $excludedPath)) {
                return false;
            }
        }

        // Ne tracker que les réponses HTML
        $contentType = $request->header('Accept');
        if ($contentType && !str_contains($contentType, 'text/html')) {
            return false;
        }

        return true;
    }
}
