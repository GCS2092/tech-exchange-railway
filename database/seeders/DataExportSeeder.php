<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DataExportSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Début de l\'importation du backup SQL...');
        
        // Chemin vers votre fichier sauvegarde.sql
        $backupPath = database_path('sauvegarde.sql');
        
        if (!File::exists($backupPath)) {
            $this->command->error("Le fichier sauvegarde.sql n'existe pas dans database/");
            $this->command->info("Placez votre fichier sauvegarde.sql dans : " . $backupPath);
            return;
        }
        
        try {
            // Lire le contenu du fichier SQL
            $sql = File::get($backupPath);
            
            // Adaptations pour PostgreSQL si nécessaire
            $sql = $this->adaptSqlForPostgreSQL($sql);
            
            // Désactiver les contraintes temporairement
            DB::statement('SET session_replication_role = replica;');
            
            // Exécuter le SQL (attention aux gros fichiers)
            $this->executeSqlFile($sql);
            
            // Réactiver les contraintes
            DB::statement('SET session_replication_role = DEFAULT;');
            
            $this->command->info('Importation terminée avec succès !');
            
        } catch (\Exception $e) {
            $this->command->error('Erreur lors de l\'importation : ' . $e->getMessage());
            throw $e;
        }
    }
    
    private function adaptSqlForPostgreSQL($sql)
    {
        // Adaptations courantes MySQL -> PostgreSQL
        $adaptations = [
            // Guillemets pour les identifiants (enlever le modificateur 'g')
            '/`([^`]+)`/' => '"$1"',
            
            // Types de données
            '/INT\(\d+\)/i' => 'INTEGER',
            '/TINYINT\(\d+\)/i' => 'SMALLINT',
            '/BIGINT\(\d+\)/i' => 'BIGINT',
            '/VARCHAR\((\d+)\)/i' => 'VARCHAR($1)',
            '/LONGTEXT/i' => 'TEXT',
            '/DATETIME/i' => 'TIMESTAMP',
            '/AUTO_INCREMENT/i' => '',
            
            // Moteur de stockage MySQL
            '/ENGINE=\w+/i' => '',
            '/DEFAULT CHARSET=\w+/i' => '',
            '/COLLATE=\w+/i' => '',
            
            // Clés primaires auto-increment
            '/PRIMARY KEY \(`?(\w+)`?\)/i' => 'PRIMARY KEY',
            
            // Fonctions spécifiques
            '/NOW\(\)/i' => 'CURRENT_TIMESTAMP',
            '/CURDATE\(\)/i' => 'CURRENT_DATE',
            
            // Autres adaptations courantes
            '/UNSIGNED/i' => '',
            '/ON UPDATE CURRENT_TIMESTAMP/i' => '',
        ];
        
        foreach ($adaptations as $pattern => $replacement) {
            $sql = preg_replace($pattern, $replacement, $sql);
        }
        
        return $sql;
    }
    
    private function executeSqlFile($sql)
    {
        // Debug : afficher les informations sur le fichier
        $this->command->info("Taille du contenu SQL : " . strlen($sql) . " caractères");
        $this->command->info("Premières 200 chars : " . substr($sql, 0, 200));
        
        // Diviser le SQL en statements individuels
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            function($statement) {
                return !empty($statement) && !preg_match('/^(--|\/\*)/', $statement);
            }
        );
        
        $this->command->info("Nombre de statements trouvés : " . count($statements));
        
        // Debug : afficher les premiers statements
        foreach (array_slice($statements, 0, 3) as $i => $stmt) {
            $this->command->line("Statement " . ($i + 1) . ": " . substr($stmt, 0, 100) . "...");
        }
        
        if (count($statements) === 0) {
            $this->command->warn("Aucune requête SQL valide trouvée dans le fichier !");
            return;
        }
        
        $this->command->info("Exécution de " . count($statements) . " requêtes...");
        
        foreach ($statements as $index => $statement) {
            if (!empty(trim($statement))) {
                try {
                    DB::statement($statement);
                    
                    // Progression
                    if (($index + 1) % 100 === 0) {
                        $this->command->info("Requêtes exécutées : " . ($index + 1));
                    }
                    
                } catch (\Exception $e) {
                    $this->command->warn("Erreur sur la requête " . ($index + 1) . ": " . $e->getMessage());
                    $this->command->line("Requête: " . substr($statement, 0, 100) . "...");
                    // Continuer malgré l'erreur (optionnel)
                    continue;
                }
            }
        }
    }
}