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
        Schema::create('animateur_competences', function (Blueprint $table) {
            $table->id('idAnimateurCompetences');
            $table->foreignId('idAnim')->constrained('animateurs', 'idAnim');
            $table->foreignId('idCompetence')->constrained('competences', 'idCompetence');
            $table->primary(['idAnim', 'idCompetence']);
            $table->string('maitrise');
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
        Schema::dropIfExists('animateur_competences');
    }
};
