<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Champs pour appareils électroniques
            $table->string('brand')->nullable(); // Marque (Apple, Samsung, etc.)
            $table->string('model')->nullable(); // Modèle spécifique (iPhone 14, Galaxy S23, etc.)
            $table->string('condition')->nullable(); // État: Neuf, Très bon, Bon, Acceptable
            $table->integer('year_of_manufacture')->nullable(); // Année de fabrication
            $table->text('technical_specs')->nullable(); // Spécifications techniques (JSON)
            $table->boolean('is_trade_eligible')->default(false); // Éligible au troc
            $table->decimal('trade_value', 10, 2)->nullable(); // Valeur d'échange
            $table->text('trade_conditions')->nullable(); // Conditions d'échange
            $table->string('device_type')->nullable(); // Type: smartphone, tablet, laptop, etc.
            $table->string('storage_capacity')->nullable(); // Capacité de stockage
            $table->string('color')->nullable(); // Couleur
            $table->boolean('has_original_box')->default(false); // Boîte d'origine
            $table->boolean('has_original_accessories')->default(false); // Accessoires d'origine
            $table->text('defects_description')->nullable(); // Description des défauts
            $table->string('warranty_status')->nullable(); // Statut de garantie
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'model', 'condition', 'year_of_manufacture',
                'technical_specs', 'is_trade_eligible', 'trade_value',
                'trade_conditions', 'device_type', 'storage_capacity',
                'color', 'has_original_box', 'has_original_accessories',
                'defects_description', 'warranty_status'
            ]);
        });
    }
}; 