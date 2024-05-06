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
        Schema::create('offre_activite', function (Blueprint $table) {
            $table->id();
            $table->decimal('tarif', 8, 2);
            $table->integer('effmax');
            $table->integer('effmin');
            $table->integer('nbrSeance');
            $table->integer('Duree');
            $table->foreignId('offre_id')->nullable()->constrained('offre')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payment_gateway')->onDelete('set null');
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
        Schema::table('offre_activite', function (Blueprint $table) {
            $table->dropForeign(['offre_id']);
            $table->dropForeign(['payment_id']);
            $table->dropColumn(['offre_id', 'payment_id']);
        });
    }
};
