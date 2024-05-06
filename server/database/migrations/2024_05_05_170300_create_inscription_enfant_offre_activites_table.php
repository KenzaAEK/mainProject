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
        Schema::create('inscription_enfant_offre_activites', function (Blueprint $table) {
            $table->id('idInscriptionEnfantOffreActivite');
            $table->fereignId('idEnfant')->constrained('enfants', 'idEnfant');
            $table->foreignId('idOffreActivite')->constrained('offre_activites', 'idOffreActivite');
            $table->foreignId('idDemande')->constrained('demandeInscriptions', 'idDemande');
            $table->foreignId('idPack')->constrained('packs', 'idPack');
            
            
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
        Schema::dropIfExists('inscription_enfant_offre_activites');
    }
};
