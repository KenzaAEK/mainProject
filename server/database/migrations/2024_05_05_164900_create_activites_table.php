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
        Schema::create('activites', function (Blueprint $table) {
            $table->id('idActivite');
            $table->string('titre');
            $table->string('description');
            $table->string('objectif');
            $table->integer('ageMin');
            $table->integer('ageMax');
            $table->string('imagePub');
            $table->integer('lienYtb');
            $table->string('programmePdf');
            $table->foreignId('idTypeActivite')->constrained('type_activites','idTypeActivite')->onDelete('set null');

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
        Schema::dropIfExists('activites');
    }
};
