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
        Schema::table('promotions', function (Blueprint $table) {
            if (!Schema::hasColumn('promotions', 'max_uses')) {
                $table->integer('max_uses')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('promotions', 'min_order_amount')) {
                $table->decimal('min_order_amount', 10, 2)->nullable()->after('max_uses');
            }
            if (!Schema::hasColumn('promotions', 'description')) {
                $table->text('description')->nullable()->after('min_order_amount');
            }
            if (!Schema::hasColumn('promotions', 'seller_id')) {
                $table->unsignedBigInteger('seller_id')->nullable()->after('description');
                $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn(['is_active', 'max_uses', 'min_order_amount', 'description', 'seller_id']);
        });
    }
};
