<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeInscriptionNotifTable extends Migration
{
    public function up()
    {
        Schema::create('demande_inscription_notif', function (Blueprint $table) {
            $table->foreignId('idNotif')->primary(); // Définir comme clé primaire
            $table->foreign('idNotif')
                  ->references('idNotif') // Assurez-vous que cela correspond à la colonne clé primaire dans `notifications`
                  ->on('notifications')
                  ->onDelete('cascade');

            $table->foreignId('idDevis')
                  ->constrained('devis','idDevis')
                  ->onDelete('cascade');
                   // Assurez-vous que la table `devis` existe

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demande_inscription_notif');
    }
}
