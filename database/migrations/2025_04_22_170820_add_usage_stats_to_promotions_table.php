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
        Schema::table('promotions', function (Blueprint $table) {
            $table->timestamp('last_used_at')->nullable();
            $table->unsignedBigInteger('last_used_by_id')->nullable();
            $table->integer('uses_count')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['last_used_at', 'last_used_by_id', 'uses_count']);
        });
    }
};
