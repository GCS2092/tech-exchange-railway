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
        Schema::table('products', function (Blueprint $table) {
            // Champs pour la gestion des alertes de stock
            $table->integer('min_stock_alert')->default(5)->after('quantity'); // Seuil d'alerte de stock faible
            $table->integer('max_stock_alert')->default(50)->after('min_stock_alert'); // Seuil d'alerte de stock élevé
            $table->timestamp('last_stock_alert_sent')->nullable()->after('max_stock_alert'); // Dernière alerte envoyée
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_stock_alert', 'max_stock_alert', 'last_stock_alert_sent']);
        });
    }
};
