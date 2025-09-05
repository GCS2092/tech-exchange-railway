<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\PageView;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

// Mails Admin
use App\Mail\LowStockAlertMail;
use App\Mail\DailyLowStockReportMail;
use App\Mail\DailyTransactionsReportMail;
use App\Mail\UserBlockedMail;
use App\Mail\UserUnblockedMail;
use App\Mail\CommandAssignedToLivreur;
use App\Mail\NewOrderNotificationMail;
use App\Mail\SystemAlertMail;
use App\Mail\WeeklyAnalyticsReportMail;
use App\Mail\AdminUserActionNotificationMail;
use App\Mail\VendorSalesReportMail;
use App\Mail\AdminVendorSalesReportMail;

// Mails Utilisateurs
use App\Mail\RegisterCodeMail;
use App\Mail\PasswordResetCodeMail;
use App\Mail\RewardUnlockedMail;
use App\Mail\WelcomeSellerMail;

class TestAllEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:all-emails {--type=all : Type de mail à tester (all, admin, user, specific)} {--email= : Email spécifique pour les tests}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester TOUS les mails du système (admin, utilisateurs, vendeurs, livreurs)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        $specificEmail = $this->option('email');
        
        $this->info('🧪 Test complet de tous les mails du système');
        $this->info('=============================================');

        // Récupérer ou créer des utilisateurs de test
        $testUsers = $this->getTestUsers($specificEmail);
        
        if (empty($testUsers)) {
            $this->error('Aucun utilisateur de test disponible.');
            return 1;
        }

        $this->info('Utilisateurs de test :');
        foreach ($testUsers as $role => $user) {
            $this->info("  - {$role}: {$user->name} ({$user->email})");
        }
        $this->newLine();

        switch ($type) {
            case 'admin':
                $this->testAdminEmails($testUsers);
                break;
            case 'user':
                $this->testUserEmails($testUsers);
                break;
            case 'specific':
                $this->testSpecificEmails($testUsers);
                break;
            case 'all':
            default:
                $this->testAllEmailTypes($testUsers);
                break;
        }

        $this->info('✅ Tests terminés !');
        return 0;
    }

    /**
     * Récupérer ou créer des utilisateurs de test
     */
    private function getTestUsers($specificEmail = null)
    {
        $users = [];

        if ($specificEmail) {
            $user = User::where('email', $specificEmail)->first();
            if ($user) {
                $role = $user->roles->first()->name ?? 'user';
                $users[$role] = $user;
                return $users;
            }
        }

        // Admin
        $admin = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->first();
        if ($admin) $users['admin'] = $admin;

        // Utilisateur normal
        $user = User::whereDoesntHave('roles', function($query) {
            $query->whereIn('name', ['admin', 'seller', 'livreur']);
        })->first();
        if ($user) $users['user'] = $user;

        // Vendeur
        $seller = User::whereHas('roles', function($query) {
            $query->where('name', 'seller');
        })->first();
        if ($seller) $users['seller'] = $seller;

        // Livreur
        $livreur = User::whereHas('roles', function($query) {
            $query->where('name', 'livreur');
        })->first();
        if ($livreur) $users['livreur'] = $livreur;

        return $users;
    }

    /**
     * Tester tous les types de mails
     */
    private function testAllEmailTypes($users)
    {
        $this->info('📧 Test de TOUS les types de mails');
        $this->info('==================================');
        
        $this->testAdminEmails($users);
        $this->newLine();
        $this->testUserEmails($users);
        $this->newLine();
        $this->testSpecificEmails($users);
    }

    /**
     * Tester les mails admin
     */
    private function testAdminEmails($users)
    {
        if (!isset($users['admin'])) {
            $this->warn('Aucun admin trouvé pour tester les mails admin.');
            return;
        }

        $admin = $users['admin'];
        $this->info('👨‍💼 Test des mails ADMIN');
        $this->info('------------------------');

        // 1. Alerte de stock faible
        $this->testStockAlertMail($admin);

        // 2. Rapport quotidien des stocks
        $this->testDailyStockReportMail($admin);

        // 3. Rapport des transactions
        $this->testTransactionsReportMail($admin);

        // 4. Notification de blocage d'utilisateur
        if (isset($users['user'])) {
            $this->testUserBlockedMail($admin, $users['user']);
        }

        // 5. Notification de déblocage d'utilisateur
        if (isset($users['user'])) {
            $this->testUserUnblockedMail($admin, $users['user']);
        }

        // 6. Notification d'assignation de commande
        if (isset($users['livreur'])) {
            $this->testCommandAssignedMail($admin, $users['livreur']);
        }

        // 7. Nouvelle commande
        $this->testNewOrderNotificationMail($admin);

        // 8. Alerte système
        $this->testSystemAlertMail($admin);

        // 9. Rapport hebdomadaire analytics
        $this->testWeeklyAnalyticsMail($admin);

        // 10. Rapport de ventes vendeurs (admin)
        $this->testVendorSalesReportMail($admin);
    }

    /**
     * Tester les mails utilisateurs
     */
    private function testUserEmails($users)
    {
        $this->info('👤 Test des mails UTILISATEURS');
        $this->info('-----------------------------');

        // Test avec un utilisateur normal
        if (isset($users['user'])) {
            $user = $users['user'];
            $this->testRegisterCodeMail($user);
            $this->testPasswordResetCodeMail($user);
            $this->testRewardUnlockedMail($user);
        }

        // Test avec un vendeur
        if (isset($users['seller'])) {
            $seller = $users['seller'];
            $this->testWelcomeSellerMail($seller);
            $this->testVendorIndividualSalesReportMail($seller);
        }
    }

    /**
     * Tester des mails spécifiques
     */
    private function testSpecificEmails($users)
    {
        $this->info('🎯 Test des mails SPÉCIFIQUES');
        $this->info('----------------------------');

        // Test de mails croisés (admin vers utilisateur, etc.)
        if (isset($users['admin']) && isset($users['user'])) {
            $this->info('Test de notification admin vers utilisateur...');
            // Ici on pourrait tester des mails personnalisés
        }
    }

    // === MÉTHODES DE TEST ADMIN ===

    private function testStockAlertMail($admin)
    {
        $this->info('📦 Test : Alerte de stock faible');
        
        $product = Product::where('quantity', '<=', 5)->first();
        
        if (!$product) {
            $this->warn('Création d\'un produit de test...');
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
    }

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
    }

    private function testTransactionsReportMail($admin)
    {
        $this->info('💰 Test : Rapport quotidien des transactions');
        
        try {
            $date = now()->format('d/m/Y');
            $transactions = []; // Données de test
            $orders = []; // Données de test
            
            Mail::to($admin->email)->send(new DailyTransactionsReportMail($transactions, $orders, $date));
            $this->info("✅ Rapport des transactions envoyé");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testUserBlockedMail($admin, $user)
    {
        $this->info('🚫 Test : Notification de blocage d\'utilisateur');
        
        try {
            // ✅ LOGIQUE CORRECTE : Email à l'utilisateur (pas à l'admin)
            Mail::to($user->email)->send(new UserBlockedMail($user, $admin));
            $this->info("✅ Notification de blocage envoyée à l'utilisateur : {$user->name}");
            
            // ✅ Email de confirmation à l'admin
            Mail::to($admin->email)->send(new AdminUserActionNotificationMail($admin, $user, 'block'));
            $this->info("✅ Confirmation d'action envoyée à l'admin : {$admin->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testUserUnblockedMail($admin, $user)
    {
        $this->info('✅ Test : Notification de déblocage d\'utilisateur');
        
        try {
            // ✅ LOGIQUE CORRECTE : Email à l'utilisateur (pas à l'admin)
            Mail::to($user->email)->send(new UserUnblockedMail($user, $admin));
            $this->info("✅ Notification de déblocage envoyée à l'utilisateur : {$user->name}");
            
            // ✅ Email de confirmation à l'admin
            Mail::to($admin->email)->send(new AdminUserActionNotificationMail($admin, $user, 'unblock'));
            $this->info("✅ Confirmation d'action envoyée à l'admin : {$admin->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testCommandAssignedMail($admin, $livreur)
    {
        $this->info('🚚 Test : Notification d\'assignation de commande');
        
        $order = Order::first();
        if (!$order) {
            $this->warn('Aucune commande trouvée pour le test.');
            return;
        }

        try {
            Mail::to($admin->email)->send(new CommandAssignedToLivreur($order, $livreur));
            $this->info("✅ Notification d'assignation envoyée pour la commande #{$order->id}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testNewOrderNotificationMail($admin)
    {
        $this->info('🛒 Test : Notification de nouvelle commande');
        
        $order = Order::with('user')->first();
        if (!$order) {
            $this->warn('Aucune commande trouvée pour le test.');
            return;
        }

        try {
            Mail::to($admin->email)->send(new NewOrderNotificationMail($order, $admin));
            $this->info("✅ Notification de nouvelle commande envoyée pour #{$order->id}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testSystemAlertMail($admin)
    {
        $this->info('🚨 Test : Alerte système');
        
        try {
            Mail::to($admin->email)->send(new SystemAlertMail(
                'warning',
                'Test d\'alerte système',
                ['details' => 'Ceci est un test d\'alerte système'],
                $admin
            ));
            $this->info("✅ Alerte système envoyée");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testWeeklyAnalyticsMail($admin)
    {
        $this->info('📈 Test : Rapport hebdomadaire analytics');
        
        try {
            Mail::to($admin->email)->send(new WeeklyAnalyticsReportMail($admin));
            $this->info("✅ Rapport hebdomadaire analytics envoyé");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testVendorSalesReportMail($admin)
    {
        $this->info('📊 Test : Rapport de ventes vendeurs (admin)');
        
        try {
            Mail::to($admin->email)->send(new AdminVendorSalesReportMail($admin, 'daily'));
            $this->info("✅ Rapport de ventes vendeurs envoyé à l'admin");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testVendorIndividualSalesReportMail($vendor)
    {
        $this->info('📊 Test : Rapport de ventes individuel vendeur');
        
        try {
            Mail::to($vendor->email)->send(new VendorSalesReportMail($vendor, 'daily'));
            $this->info("✅ Rapport de ventes individuel envoyé au vendeur : {$vendor->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    // === MÉTHODES DE TEST UTILISATEURS ===

    private function testRegisterCodeMail($user)
    {
        $this->info('📧 Test : Code d\'inscription');
        
        try {
            $code = '123456'; // Code de test
            Mail::to($user->email)->send(new RegisterCodeMail($code));
            $this->info("✅ Code d'inscription envoyé à : {$user->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testPasswordResetCodeMail($user)
    {
        $this->info('🔐 Test : Code de réinitialisation de mot de passe');
        
        try {
            $code = '654321'; // Code de test
            Mail::to($user->email)->send(new PasswordResetCodeMail($code));
            $this->info("✅ Code de réinitialisation envoyé à : {$user->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testRewardUnlockedMail($user)
    {
        $this->info('🎁 Test : Récompense débloquée');
        
        try {
            Mail::to($user->email)->send(new RewardUnlockedMail($user));
            $this->info("✅ Notification de récompense envoyée à : {$user->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }

    private function testWelcomeSellerMail($seller)
    {
        $this->info('👨‍💼 Test : Bienvenue vendeur');
        
        try {
            Mail::to($seller->email)->send(new WelcomeSellerMail($seller));
            $this->info("✅ Mail de bienvenue envoyé au vendeur : {$seller->name}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur : " . $e->getMessage());
        }
    }
}
