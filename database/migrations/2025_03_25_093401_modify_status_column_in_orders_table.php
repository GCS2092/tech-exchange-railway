<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On modifie la colonne status pour qu'elle soit un ENUM avec des valeurs précises
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('en attente', 'expédié', 'livré') DEFAULT 'en attente'");
    }

    public function down(): void
    {
        // Si on veut revenir en arrière, on remet en VARCHAR
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(255) DEFAULT 'en attente'");
    }
};
