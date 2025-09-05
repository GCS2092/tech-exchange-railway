<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Modifier la colonne price pour augmenter la précision
            // De decimal(8, 2) à decimal(12, 2) pour supporter des valeurs jusqu'à 9,999,999,999.99
            $table->decimal('price', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Revenir à la précision originale
            $table->decimal('price', 8, 2)->nullable()->change();
        });
    }
};
