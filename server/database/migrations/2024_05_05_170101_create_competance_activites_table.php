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
            $table->id('competance_activite_id');
            $table->foreignId('type_activite_id')->constrained('type_activites', 'type_activite_id');
            $table->foreignId('competence_id')->constrained('competences', 'id_competence');
            $table->integer('niveau_requis');
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
