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
        Schema::create('disponibilite_animateur', function (Blueprint $table) {
            $table->foreignId('idAnim')->constrained('animateurs','idAnim');  
            $table->foreignId('idHoraire')->constrained('horaires','idHoraire');    
            //$table->primary(['idAnim', 'idHoraire']);   
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
        Schema::dropIfExists('disponibilite_animateurs');
    }
};
