<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\OnboardingHelper;

class OnboardingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Enregistrer le helper dans les vues
        $this->app['view']->composer('*', function ($view) {
            $view->with('onboardingHelper', new OnboardingHelper());
        });
    }
} 