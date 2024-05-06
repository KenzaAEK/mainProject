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
        Schema::create('animateur_groupes', function (Blueprint $table) {
            $table->foreignId('idAnim')->constrained('animateurs', 'idAnim');
            $table->foreignId('idGroupe')->constrained('groupes', 'idGroupe');
            //$table->primary([, 'idAnim', 'idGroupe']);
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
        Schema::dropIfExists('animateur_groupes');
    }
};
