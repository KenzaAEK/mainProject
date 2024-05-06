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
            $table->foreignId('animateur_id')->constrained();  
            $table->foreignId('horaire_id')->constrained();    
            $table->primary(['animateur_id', 'horaire_id']);   
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
