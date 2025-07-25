<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->after('total_price');
            $table->decimal('discount_amount', 10, 2)->nullable()->after('original_price');
            $table->string('promo_code')->nullable()->after('discount_amount');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discount_amount', 'promo_code']);
        });
    }
}; 