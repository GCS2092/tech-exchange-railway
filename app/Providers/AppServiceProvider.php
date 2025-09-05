<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\NavigationController;

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
        // Register Spatie middleware aliases for Laravel 11
        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);
        $this->app['router']->aliasMiddleware('permission', PermissionMiddleware::class);
        $this->app['router']->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
        
        // Share navigation data with all views that use the main layout
        View::composer(['layouts.navigation', 'layouts.app'], function ($view) {
            $view->with('navData', NavigationController::getNavigationData());
        });
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
