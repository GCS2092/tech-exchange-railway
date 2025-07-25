<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'username')) {
            $table->string('username')->unique()->after('name');
        }
        // profile_photo déjà existante, donc on ne la rajoute pas
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('username');
        // on ne touche pas à profile_photo
    });
}

    
};
