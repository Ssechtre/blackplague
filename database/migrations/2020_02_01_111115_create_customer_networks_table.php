<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_networks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_pid');
            $table->foreign('user_pid')->references('id')->on('users');
            $table->unsignedInteger('user_cid');
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
        Schema::dropIfExists('customer_networks');
    }
}
