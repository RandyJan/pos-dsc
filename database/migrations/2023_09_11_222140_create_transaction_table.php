<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('pumpid');
            $table->float('pump');
            $table->integer('transaction');
            $table->integer('state');
            $table->string('nozzle');
            $table->float('amount');
            $table->float('volume');
            $table->float('price');
            $table->float('tcvolume');
            $table->float('totalamount');
            $table->float('totalvolume');
            $table->string('userid');
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
        Schema::dropIfExists('transaction');
    }
}
