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
            $table->integer('pumpid')->nullable();
            $table->float('pump')->nullable();
            $table->integer('transaction')->nullable();
            $table->integer('state')->nullable();
            $table->string('nozzle')->nullable();
            $table->float('amount')->nullable();
            $table->float('volume')->nullable();
            $table->float('price')->nullable();
            $table->float('tcvolume')->nullable();
            $table->float('totalamount')->nullable();
            $table->float('totalvolume')->nullable();
            $table->string('userid')->nullable();
            $table->integer('status')->nullable();
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
