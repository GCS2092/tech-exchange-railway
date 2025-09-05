<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorSalesReportMail;
use App\Mail\AdminVendorSalesReportMail;

class SendVendorSalesReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:vendor-sales {--type=daily : Type de rapport (daily, weekly, monthly)} {--send-to=vendors : Destinataires (vendors, admin, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer les rapports de ventes aux vendeurs et à l\'admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        $sendTo = $this->option('send-to');
        
        $this->info('📊 Envoi des rapports de ventes vendeurs');
        $this->info('=====================================');
        $this->info("Type de rapport : {$type}");
        $this->info("Destinataires : {$sendTo}");
        $this->newLine();

        $vendors = User::role('vendeur')->get();
        $admins = User::role('admin')->get();

        if ($vendors->isEmpty()) {
            $this->warn('Aucun vendeur trouvé dans la base de données.');
            return 1;
        }

        if ($admins->isEmpty()) {
            $this->warn('Aucun administrateur trouvé dans la base de données.');
            return 1;
        }

        $successCount = 0;
        $errorCount = 0;

        // Envoyer aux vendeurs
        if (in_array($sendTo, ['vendors', 'all'])) {
            $this->info('📧 Envoi des rapports aux vendeurs...');
            
            foreach ($vendors as $vendor) {
                try {
                    Mail::to($vendor->email)->send(new VendorSalesReportMail($vendor, $type));
                    $this->info("✅ Rapport envoyé à {$vendor->name} ({$vendor->email})");
                    $successCount++;
                } catch (\Exception $e) {
                    $this->error("❌ Erreur pour {$vendor->name} : " . $e->getMessage());
                    $errorCount++;
                }
            }
        }

        // Envoyer à l'admin
        if (in_array($sendTo, ['admin', 'all'])) {
            $this->info('📧 Envoi du rapport global à l\'admin...');
            
            foreach ($admins as $admin) {
                try {
                    Mail::to($admin->email)->send(new AdminVendorSalesReportMail($admin, $type));
                    $this->info("✅ Rapport global envoyé à {$admin->name} ({$admin->email})");
                    $successCount++;
                } catch (\Exception $e) {
                    $this->error("❌ Erreur pour {$admin->name} : " . $e->getMessage());
                    $errorCount++;
                }
            }
        }

        $this->newLine();
        $this->info('📊 Résumé de l\'envoi :');
        $this->info("✅ Succès : {$successCount}");
        $this->info("❌ Erreurs : {$errorCount}");
        $this->info("📧 Total envoyés : " . ($successCount + $errorCount));

        return 0;
    }
}
