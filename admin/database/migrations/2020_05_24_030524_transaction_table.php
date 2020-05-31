<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transaction_table', function (Blueprint $table) {
        $table->increments('id');
        $table->string('Date');
        $table->string('Round');
        $table->integer('Total')->default(0);
        $table->integer('Bet_Status')->default(0);
        $table->integer('Balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
