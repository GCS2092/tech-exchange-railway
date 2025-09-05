<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlertMail;
use App\Mail\DailyLowStockReportMail;
use App\Mail\DailyTransactionsReportMail;
use App\Mail\UserBlockedMail;
use App\Mail\UserUnblockedMail;
use App\Mail\CommandAssignedToLivreur;

class TestAdminEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:admin-emails {--type=all : Type de mail à tester (all, stock-alert, daily-report, transactions, user-blocked, user-unblocked, command-assigned)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester tous les mails envoyés à l\'administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        
        $this->info('🧪 Test des mails administrateur');
        $this->info('=====================================');

        // Récupérer un admin pour les tests
        $admin = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$admin) {
            $this->error('Aucun administrateur trouvé dans la base de données.');
            return 1;
        }

        $this->info("Admin de test : {$admin->name} ({$admin->email})");
        $this->newLine();

        switch ($type) {
            case 'stock-alert':
                $this->testStockAlertMail($admin);
                break;
            case 'daily-report':
                $this->testDailyStockReportMail($admin);
                break;
            case 'transactions':
                $this->testTransactionsReportMail($admin);
                break;
            case 'user-blocked':
                $this->testUserBlockedMail($admin);
                break;
            case 'user-unblocked':
                $this->testUserUnblockedMail($admin);
                break;
            case 'command-assigned':
                $this->testCommandAssignedMail($admin);
                break;
            case 'all':
            default:
                $this->testAllMails($admin);
                break;
        }

        $this->info('✅ Tests terminés !');
        return 0;
    }

    /**
     * Tester tous les mails
     */
    private function testAllMails($admin)
    {
        $this->testStockAlertMail($admin);
        $this->testDailyStockReportMail($admin);
        $this->testTransactionsReportMail($admin);
        $this->testUserBlockedMail($admin);
        $this->testUserUnblockedMail($admin);
        $this->testCommandAssignedMail($admin);
    }

    /**
     * Tester l'alerte de stock faible
     */
    private function testStockAlertMail($admin)
    {
        $this->info('📦 Test : Alerte de stock faible');
        
        $product = Product::where('quantity', '<=', 5)->first();
        
        if (!$product) {
            $this->warn('Aucun produit en stock faible trouvé. Création d\'un produit de test...');
            $product = Product::create([
                'name' => 'Produit Test - Stock Faible',
                'description' => 'Produit de test pour l\'alerte de stock',
                'price' => 15000,
                'quantity' => 2,
                'is_active' => true,
                'min_stock_alert' => 5,
            ]);
        }

        try {
            Mail::to($admin->email)->send(new LowStockAlertMail($product));
            $this->info("✅ Mail d'alerte de stock envoyé pour : {$product->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * Tester le rapport quotidien des stocks
     */
    private function testDailyStockReportMail($admin)
    {
        $this->info('📊 Test : Rapport quotidien des stocks faibles');
        
        $lowStockProducts = Product::with(['category', 'seller'])
            ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'))
            ->where('is_active', true)
            ->orderBy('quantity', 'asc')
            ->get();

        if ($lowStockProducts->isEmpty()) {
            $this->warn('Aucun produit en stock faible trouvé pour le rapport.');
            return;
        }

        try {
            Mail::to($admin->email)->send(new DailyLowStockReportMail($lowStockProducts, $admin));
            $this->info("✅ Rapport quotidien envoyé avec {$lowStockProducts->count()} produit(s)");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * Tester le rapport des transactions
     */
    private function testTransactionsReportMail($admin)
    {
        $this->info('💰 Test : Rapport quotidien des transactions');
        
        try {
            Mail::to($admin->email)->send(new DailyTransactionsReportMail());
            $this->info("✅ Rapport des transactions envoyé");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * Tester la notification de blocage d'utilisateur
     */
    private function testUserBlockedMail($admin)
    {
        $this->info('🚫 Test : Notification de blocage d\'utilisateur');
        
        $user = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$user) {
            $this->warn('Aucun utilisateur non-admin trouvé pour le test.');
            return;
        }

        try {
            Mail::to($admin->email)->send(new UserBlockedMail($user));
            $this->info("✅ Notification de blocage envoyée pour : {$user->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * Tester la notification de déblocage d'utilisateur
     */
    private function testUserUnblockedMail($admin)
    {
        $this->info('✅ Test : Notification de déblocage d\'utilisateur');
        
        $user = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$user) {
            $this->warn('Aucun utilisateur non-admin trouvé pour le test.');
            return;
        }

        try {
            Mail::to($admin->email)->send(new UserUnblockedMail($user));
            $this->info("✅ Notification de déblocage envoyée pour : {$user->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * Tester la notification d'assignation de commande
     */
    private function testCommandAssignedMail($admin)
    {
        $this->info('🚚 Test : Notification d\'assignation de commande');
        
        $order = Order::first();
        $livreur = User::whereHas('roles', function($query) {
            $query->where('name', 'livreur');
        })->first();

        if (!$order) {
            $this->warn('Aucune commande trouvée pour le test.');
            return;
        }

        if (!$livreur) {
            $this->warn('Aucun livreur trouvé pour le test.');
            return;
        }

        try {
            Mail::to($admin->email)->send(new CommandAssignedToLivreur($order, $livreur));
            $this->info("✅ Notification d'assignation envoyée pour la commande #{$order->id}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
        
        $this->newLine();
    }
}
