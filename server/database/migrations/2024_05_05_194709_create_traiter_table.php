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
        Schema::create('traiter', function (Blueprint $table) {
            $table->foreignId('idAdmin')->constrained('administrateurs');
            $table->foreignId('idDemande')->constrained('demandeInscriptions');
            $table->enum('statut', ['en cours de traitement', 'accepter', 'refuser']);
            $table->text('motifRefus')->nullable();
            $table->timestamp('dateTraitement')->nullable();
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
        Schema::dropIfExists('traiter');
    }
};
