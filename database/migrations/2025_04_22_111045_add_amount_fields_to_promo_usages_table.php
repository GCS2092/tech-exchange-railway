<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountFieldsToPromoUsagesTable extends Migration
{
    public function up()
    {
        Schema::table('promo_usages', function (Blueprint $table) {
            $table->decimal('original_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('promo_usages', function (Blueprint $table) {
            $table->dropColumn(['original_amount', 'discount_amount', 'final_amount']);
        });
    }
}
