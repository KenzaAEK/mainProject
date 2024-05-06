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
        Schema::create('animateurs', function (Blueprint $table) {
            // Utilisation de la clé primaire auto-incrémentée par défaut
            $table->id('animateur_id'); 
            // Ajout de la colonne user_id comme clé étrangère
            $table->foreignId('idUser')
                  ->constrained('users') // Utilisation de la clé primaire par défaut de la table users
                  ->onDelete('cascade');
            $table->string('domaine_competence');
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
        Schema::dropIfExists('animateurs');
    }
};
