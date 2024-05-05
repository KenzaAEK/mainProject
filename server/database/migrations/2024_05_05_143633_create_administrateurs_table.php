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
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id('idAdmin'); // Si 'idAdmin' est la clé primaire dans la table admins
            $table->foreignId('user_id')
            ->constrained('users', 'idUser')
            ->onDelete('cascade');  // Spécifiez 'idUser' comme colonne de référence
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
        Schema::dropIfExists('administrateurs');
    }
};
