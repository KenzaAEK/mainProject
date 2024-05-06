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
        Schema::create('planning', function (Blueprint $table) {
            $table->id('idPlanning');
            $table->foreignId('idOffreActivite')->constrained('offre_activites', 'idOffreActivite')->onDelete('cascade');
            $table->foreignId('idEnfant')->constrained('enfants', 'idEnfant')->onDelete('cascade');
            $table->unique(['idOffreActivite', 'idEnfant']);
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
        Schema::dropIfExists('planning');
    }
};
