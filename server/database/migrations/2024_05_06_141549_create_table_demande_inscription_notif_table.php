<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeInscriptionNotifTable extends Migration
{
    public function up()
    {
        Schema::create('demande_inscription_notif', function (Blueprint $table) {
             
             $table->foreignId('idNotif')
             ->primary()  // Cela définit idNotif comme clé primaire
             ->constrained('notifications','idNotif')  // Pas besoin de spécifier 'idNotif' ici
             ->onDelete('cascade');

            $table->foreignId('idDevis')
                  ->constrained('devis','idDevis')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demande_inscription_notif');
    }
}
