<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offre_activites', function (Blueprint $table) {
            $table->id('idOffreActivite');
            $table->decimal('tarif', 8, 2);
            $table->integer('effmax');
            $table->integer('effmin');
            $table->integer('nbrSeance');
            $table->integer('Duree');
            $table->foreignId('idOffre')->nullable()->constrained('offres','idOffre')->onDelete('cascade');
            $table->foreignId('idPayment')->nullable()->constrained('payment_gateways','idPayment')->onDelete('set null');
            $table->foreignId('idActivite')->constrained('activites','idActivite')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offre_activites', function (Blueprint $table) {
            $table->dropForeign(['offre_id']);
            $table->dropForeign(['payment_id']);
            $table->dropColumn(['offre_id', 'payment_id']);
        });
    }
};
