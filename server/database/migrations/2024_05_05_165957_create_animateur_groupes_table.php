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
            $table->id();
            $table->foreignId('animateur_id')->constrained('animateurs', 'animateur_id');
            $table->foreignId('groupe_id')->constrained('groupes', 'groupe_id');
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
