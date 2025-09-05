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
        Schema::table('trade_offers', function (Blueprint $table) {
            // Champs pour l'appareil personnalisé de l'utilisateur
            $table->string('custom_device_name')->nullable()->after('offered_product_id');
            $table->string('custom_device_brand')->nullable()->after('custom_device_name');
            $table->string('custom_device_model')->nullable()->after('custom_device_brand');
            $table->string('custom_device_type')->nullable()->after('custom_device_model');
            $table->text('custom_device_description')->nullable()->after('custom_device_type');
            $table->string('custom_device_condition')->nullable()->after('custom_device_description');
            $table->integer('custom_device_year')->nullable()->after('custom_device_condition');
            
            // Spécifications techniques pour l'appareil personnalisé
            $table->string('custom_device_ram')->nullable()->after('custom_device_year');
            $table->string('custom_device_storage')->nullable()->after('custom_device_ram');
            $table->string('custom_device_screen_size')->nullable()->after('custom_device_storage');
            $table->string('custom_device_os')->nullable()->after('custom_device_screen_size');
            $table->string('custom_device_color')->nullable()->after('custom_device_os');
            $table->string('custom_device_processor')->nullable()->after('custom_device_color');
            $table->string('custom_device_gpu')->nullable()->after('custom_device_processor');
            
            // Montant d'argent supplémentaire
            $table->decimal('additional_cash_amount', 10, 2)->default(0)->after('custom_device_gpu');
            
            // Type d'offre (produit existant ou appareil personnalisé)
            $table->enum('offer_type', ['existing_product', 'custom_device'])->default('existing_product')->after('additional_cash_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_offers', function (Blueprint $table) {
            $table->dropColumn([
                'custom_device_name',
                'custom_device_brand',
                'custom_device_model',
                'custom_device_type',
                'custom_device_description',
                'custom_device_condition',
                'custom_device_year',
                'custom_device_ram',
                'custom_device_storage',
                'custom_device_screen_size',
                'custom_device_os',
                'custom_device_color',
                'custom_device_processor',
                'custom_device_gpu',
                'additional_cash_amount',
                'offer_type'
            ]);
        });
    }
};
