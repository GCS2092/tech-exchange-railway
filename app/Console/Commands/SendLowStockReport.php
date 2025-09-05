<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyLowStockReportMail;

class SendLowStockReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:low-stock-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer un rapport quotidien des produits en stock faible aux administrateurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Génération du rapport des stocks faibles...');

        // Récupérer tous les produits en stock faible
        $lowStockProducts = Product::with(['category', 'seller'])
            ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'))
            ->where('is_active', true)
            ->orderBy('quantity', 'asc')
            ->get();

        if ($lowStockProducts->isEmpty()) {
            $this->info('Aucun produit en stock faible trouvé.');
            return 0;
        }

        $this->info("Trouvé {$lowStockProducts->count()} produit(s) en stock faible.");

        // Récupérer tous les administrateurs
        $admins = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        if ($admins->isEmpty()) {
            $this->error('Aucun administrateur trouvé.');
            return 1;
        }

        // Envoyer le rapport à chaque administrateur
        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(new DailyLowStockReportMail($lowStockProducts, $admin));
                $this->info("Rapport envoyé à {$admin->email}");
            } catch (\Exception $e) {
                $this->error("Erreur lors de l'envoi à {$admin->email}: " . $e->getMessage());
            }
        }

        $this->info('Rapport des stocks faibles envoyé avec succès !');
        return 0;
    }
}
