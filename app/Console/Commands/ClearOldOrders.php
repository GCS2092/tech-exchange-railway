<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-old-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = 7;
        Order::where('created_at', '<', now()->subDays($days))->delete();
        $this->info("Commandes de plus de $days jours supprimées !");
    }
    
}
