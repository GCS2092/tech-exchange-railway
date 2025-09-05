<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class CheckMissingRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:check-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie les routes manquantes en comparant les vues avec les routes définies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Vérification des routes manquantes...');

        // Récupérer toutes les routes définies
        $definedRoutes = [];
        foreach (Route::getRoutes() as $route) {
            if ($route->getName()) {
                $definedRoutes[] = $route->getName();
            }
        }

        // Scanner les fichiers de vues pour les routes référencées
        $viewFiles = File::glob('resources/views/**/*.php');
        $referencedRoutes = [];

        foreach ($viewFiles as $file) {
            $content = File::get($file);
            
            // Rechercher les appels à route()
            preg_match_all("/route\s*\(\s*['\"]([^'\"]+)['\"]/", $content, $matches);
            
            if (!empty($matches[1])) {
                foreach ($matches[1] as $routeName) {
                    if (!isset($referencedRoutes[$routeName])) {
                        $referencedRoutes[$routeName] = [];
                    }
                    $referencedRoutes[$routeName][] = $file;
                }
            }
        }

        // Identifier les routes manquantes
        $missingRoutes = [];
        foreach ($referencedRoutes as $routeName => $files) {
            if (!in_array($routeName, $definedRoutes)) {
                $missingRoutes[$routeName] = $files;
            }
        }

        // Afficher les résultats
        if (empty($missingRoutes)) {
            $this->info('✅ Toutes les routes référencées dans les vues sont définies !');
        } else {
            $this->error('❌ Routes manquantes trouvées :');
            
            foreach ($missingRoutes as $routeName => $files) {
                $this->line('');
                $this->error("🔴 Route manquante : {$routeName}");
                $this->line("   Fichiers qui l'utilisent :");
                foreach ($files as $file) {
                    $this->line("   - {$file}");
                }
            }
            
            $this->line('');
            $this->error("Total : " . count($missingRoutes) . " route(s) manquante(s)");
        }

        $this->line('');
        $this->info("=== STATISTIQUES ===");
        $this->line("Routes définies : " . count($definedRoutes));
        $this->line("Routes référencées : " . count($referencedRoutes));
        $this->line("Routes manquantes : " . count($missingRoutes));

        return 0;
    }
}
