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
        Schema::create('offres', function (Blueprint $table) {
            $table->id('idOffre');
            $table->foreignId('idAdmin')
            ->constrained('administrateurs','idAdmin')
            ->onDelete('cascade');
            $table->decimal('remise', 8, 2)->nullable();
            $table->date('dateDebutOffre')->nullable();
            $table->date('dateFinOffre')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('offres');
    }
};
