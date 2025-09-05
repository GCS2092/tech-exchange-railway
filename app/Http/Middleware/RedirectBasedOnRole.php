<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Éviter la boucle infinie en vérifiant si on est déjà sur la bonne route
            $currentRoute = $request->route()->getName();
            
            // Routes à exclure de la redirection automatique
            $excludedRoutes = [
                'profile.edit', 'profile.update', 'profile.destroy',
                'logout', 'products.index', 'products.show',
                'trades.show', 'trades.search', 'cart.index'
            ];
            
            if (in_array($currentRoute, $excludedRoutes)) {
                return $next($request);
            }
            
            // Rediriger vers le dashboard approprié selon le rôle SEULEMENT depuis /dashboard
            if ($currentRoute === 'dashboard') {
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('vendeur')) {
                    return redirect()->route('vendeur.dashboard');
                } elseif ($user->hasRole('livreur')) {
                    return redirect()->route('livreur.orders.index');
                }
                // Utilisateur normal reste sur le dashboard
            }
        }

        return $next($request);
    }
} 