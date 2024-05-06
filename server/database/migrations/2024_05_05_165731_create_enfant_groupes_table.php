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
        Schema::create('enfant_groupe', function (Blueprint $table) {
            $table->foreignId('enfant_id')->constrained('enfant');
            $table->foreignId('groupe_id')->constrained('groupe');
            $table->primary(['enfant_id', 'groupe_id']);
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
        Schema::dropIfExists('enfant_groupes');
    }
};
