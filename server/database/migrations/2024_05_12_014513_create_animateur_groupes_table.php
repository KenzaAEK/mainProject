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
        Schema::create('animateur_groupes', function (Blueprint $table) {
            $table->unsignedBigInteger('idAnimateur');
            $table->unsignedBigInteger('idGroupe');
        
            $table->foreign('idAnimateur')->references('idAnimateur')->on('animateurs')->onDelete('cascade');
            $table->foreign('idGroupe')->references('idGroupe')->on('groupes')->onDelete('cascade');
        
            $table->primary(['idAnimateur', 'idGroupe']); 
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animateur_groupes');
    }
};
