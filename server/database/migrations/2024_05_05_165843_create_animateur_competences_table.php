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
            $table->id();
            $table->foreignId('animateur_id')->constrained('animateurs', 'id_animateur');
            $table->foreignId('competence_id')->constrained('competences', 'id_competence');
            $table->integer('maitrise');
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
