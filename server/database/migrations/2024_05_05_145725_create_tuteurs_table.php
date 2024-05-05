<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tuteurs', function (Blueprint $table) {
            $table->id('idTuteur');
            $table->foreignId('user_id')
            ->constrained('users', 'idUser')
            ->onDelete('cascade');
            $table->string('fonction')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parents');
    }
};
