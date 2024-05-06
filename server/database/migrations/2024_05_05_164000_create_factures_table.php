<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id('idFacture');
            $table->decimal('totalHT', 10, 2);
            $table->decimal('totalTTC', 10, 2);
            $table->date('dateFacture')->default(DB::raw('CURRENT_DATE'));;
            $table->string('facturePdf')->nullable();
            $table->foreignId('idNotif')->nullable()
            ->constrained('notifications','idNotif')
            ->onDelete('set null');
        });  
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
}