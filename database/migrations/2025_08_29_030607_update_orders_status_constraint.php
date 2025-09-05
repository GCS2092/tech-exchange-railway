<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer l'ancienne contrainte
        DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check");
        
        // Ajouter la nouvelle contrainte avec tous les statuts autorisés
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('en attente', 'payé', 'en préparation', 'expédié', 'en livraison', 'livré', 'annulé', 'retourné', 'remboursé'))");
    }

    public function down(): void
    {
        // Supprimer la nouvelle contrainte
        DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check");
        
        // Remettre l'ancienne contrainte
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('en attente', 'expédié', 'livré'))");
    }
};
