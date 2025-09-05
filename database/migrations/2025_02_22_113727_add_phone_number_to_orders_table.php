<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneNumberToOrdersTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Si payment_method n'existe pas, on ne la mentionne pas
            $table->string('phone_number')->nullable(); // Ajout de la colonne phone_number
        });
    }

    /**
     * Revenir en arrière sur la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('phone_number'); // Supprime la colonne phone_number si la migration est annulée
        });
    }
}
