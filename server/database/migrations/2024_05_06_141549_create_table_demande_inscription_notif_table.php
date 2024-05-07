
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    

    public function up()
    {
        Schema::create('demande_inscription_notif', function (Blueprint $table) {
            // Définir comme clé primaire
            $table->foreignId('idNotif')
            ->constrained('notifications','idNotif')  // Pas besoin de spécifier 'idNotif' ici
            ->onDelete('cascade');
            $table->unique(['idNotif']);
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
};