<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Utiliser le nouveau seeder amélioré qui créé tout ce dont nous avons besoin
        $this->call([
            EnhancedTestSeeder::class,
        ]);
        
        echo "\n🎉 Base de données peuplée avec succès !\n";
        echo "👥 Utilisateurs créés :\n";
        echo "   - Admin: slovengama@gmail.com / qwertyuiop\n";
        echo "   - Vendeur: vendeur@techhub.com / password123\n";
        echo "   - Livreur: livreur@techhub.com / password123\n";
        echo "   - Client: client@techhub.com / password123\n\n";
        echo "📱 Nombreux appareils électroniques ajoutés pour le système d'échange\n";
        echo "🔄 Offres d'échange et commandes de test créées\n\n";
        echo "🌐 Accédez au système d'échange: http://127.0.0.1:8000/trades/search\n";
    }
}
