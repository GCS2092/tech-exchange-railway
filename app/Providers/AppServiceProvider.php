<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public function redirectTo()
    {
        $user = auth()->user();
        
        if ($user->hasRole('livreur')) {
            return '/livreur/commandes';
        }

        return '/dashboard'; // ou une autre page pour les autres rôles
    }
}
