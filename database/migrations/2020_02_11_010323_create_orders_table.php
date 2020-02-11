<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->unsignedBigInteger('user_cid');
            $table->foreign('user_cid')->references('id')->on('users');
            $table->string('order_number');
            $table->text('discount_applications');
            $table->text('line_items');
            $table->decimal('subtotal_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->string('order_status');
            $table->boolean('confirmed')->default(1);
            $table->string('browser_ip');
            $table->string('remarks')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('cancelled_reason')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
