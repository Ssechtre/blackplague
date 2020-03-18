<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->unsignedBigInteger('user_cid');
            $table->foreign('user_cid')->references('id')->on('users');
            $table->string('transaction_number');
            $table->string('month')->length(50);
            $table->string('year')->length(50);
            $table->float('referral_amount');
            $table->float('commission_amount');
            $table->text('remarks')->nullable();;
            $table->string('status')->length(50);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}
