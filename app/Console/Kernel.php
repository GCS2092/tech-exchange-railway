<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Passport\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Auth\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];

    /**
     * The application's console commands.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\RolesReport::class,
        \App\Console\Commands\SendDailyTransactionsReport::class,
        \App\Console\Commands\SendLowStockReport::class,
        \App\Console\Commands\SendBiWeeklyShopReport::class,
        \App\Console\Commands\TestAdminEmails::class,
        \App\Console\Commands\TestAllEmails::class,
        \App\Console\Commands\SendVendorSalesReports::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('report:transactions-daily')->dailyAt('23:59');
        $schedule->command('report:low-stock-daily')->dailyAt('08:00');
        
        // Rapport bimensuel de l'état de la boutique (tous les 14 jours)
        $schedule->command('report:biweekly-shop')->weekly()->mondays()->at('09:00');
        
        // Rapports de ventes vendeurs
        $schedule->command('report:vendor-sales --type=daily --send-to=all')->dailyAt('20:00');
        $schedule->command('report:vendor-sales --type=weekly --send-to=all')->weekly()->mondays()->at('09:00');
        $schedule->command('report:vendor-sales --type=monthly --send-to=all')->monthlyOn(1, '10:00');
        
        $schedule->command('inspire')->hourly();
    }
} 