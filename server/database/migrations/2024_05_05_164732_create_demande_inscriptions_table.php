<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandeInscriptions', function (Blueprint $table) {
            $table->id('idDemande'); // ID de la demande
            $table->foreignId('idTuteur')->constrained('tuteurs','idTuteur')->onDelete('cascade');
            $table->string('optionsPaiement'); // Options de paiement choisies
            $table->enum('status', ['en attente', 'acceptée', 'refusée'])->default('en attente');
            $table->timestamp('dateDemande')->default(DB::raw('CURRENT_TIMESTAMP')); // Date de la demande
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandeInscriptions');
    }
};
