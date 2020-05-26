<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { //
        Schema::create('setting_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bet_type');
            $table->string('payout');
            $table->integer('max_amount')->default(0);
            $table->integer('difference')->default(0);
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
        //
    }
}
