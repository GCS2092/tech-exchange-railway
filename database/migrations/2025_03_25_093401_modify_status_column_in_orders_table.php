<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL compatible - on utilise un check constraint au lieu d'ENUM
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('en attente', 'expédié', 'livré'))");
    }

    public function down(): void
    {
        // Supprimer la contrainte
        DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check");
    }
};
