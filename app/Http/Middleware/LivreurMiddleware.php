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
   
        // Vérifiez si l'utilisateur a le rôle delivery via Spatie Permission
        if (!Auth::user()->hasRole('delivery')) {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Vous devez être livreur.');
        }
   
        return $next($request);
    }
}