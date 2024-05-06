<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idNotif'); // Utilisation de la clé primaire auto-incrémentée par défaut
            $table->foreignId('idUser')->constrained('users', 'idUser')->onDelete('cascade') ; // Utilisation de la clé primaire par défaut de la table users
            $table->string('objet'); // Contenu de la notification
            $table->boolean('isRead')->default(false); // État de lecture, non lue par défaut
            $table->timestamps();
        });

    }

    public function down()
    {
      
        Schema::dropIfExists('notifications');
    }
};