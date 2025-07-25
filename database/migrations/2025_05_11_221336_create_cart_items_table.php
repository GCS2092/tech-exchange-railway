<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    if (!Schema::hasTable('cart_items')) {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }
}


public function down()
{
    Schema::dropIfExists('cart_items');
}

};
