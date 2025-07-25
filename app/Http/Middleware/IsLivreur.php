<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivreurMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifiez si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }
   
        // Affichez l'utilisateur dans les logs pour déboguer
        \Log::info('Utilisateur connecté: ' . Auth::user()->email);
   
        // Vérifiez si ce n'est pas un livreur
        if (!Auth::user()->hasRole('livreur')) {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Vous devez être livreur.');
        }
   
        return $next($request);
    }
}