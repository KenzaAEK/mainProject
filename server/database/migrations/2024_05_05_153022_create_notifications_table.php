<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idNotification');
            $table->foreignId('user_id')->constrained('users', 'idUser')->onDelete('cascade'); // Assurez-vous de spécifier la table 'users' et la colonne 'idUser' si c'est la clé primaire dans 'users'
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
