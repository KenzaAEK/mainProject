<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFacturesTable extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id('idFacture');
            $table->decimal('totalHT', 10, 2);
            $table->decimal('totalTTC', 10, 2);
            $table->date('dateFacture');
            $table->string('facturePdf')->nullable();
            $table->foreignId('idNotif')->nullable()// ajouter au niveau model aussi
            ->constrained('notifications','idNotif');
            $table->timestamp('created_at')->useCurrent();
        });  
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
}