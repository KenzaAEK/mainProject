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
        Schema::create('competance_activites', function (Blueprint $table) {
           
            $table->foreignId('idTypeActivite')->constrained('type_activites', 'idTypeActivite');
            $table->foreignId('idCompetence')->constrained('competences', 'idCompetence');
            $table->integer('niveau_requis');
            $table->primary(['idCompetence', 'idTypeActivite']);
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
        Schema::dropIfExists('competance_activites');
    }
};
