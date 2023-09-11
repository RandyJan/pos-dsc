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
            $table->integer('pump');
            $table->integer('transaction');
            $table->integer('state');
            $table->string('nozzle');
            $table->integer('amount');
            $table->integer('volume');
            $table->integer('price');
            $table->integer('tcvolume');
            $table->integer('totalamount');
            $table->integer('totalvolume');
            $table->integer('userid');
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
