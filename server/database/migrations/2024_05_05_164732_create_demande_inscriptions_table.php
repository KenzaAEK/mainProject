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
        Schema::create('demandeInscriptions', function (Blueprint $table) {
            $table->id('idDemande'); // ID de la demande
            $table->foreignId('idTuteur')
            ->constrained('tuteurs')
            ->onDelete('cascade');
            $table->string('optionsPaiement'); // Options de paiement choisies
            $table->string('status'); // Statut de la demande
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
