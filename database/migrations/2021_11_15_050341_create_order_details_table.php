<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->integer('order_stat');
            $table->unsignedBigInteger('product_id');
            $table->double('sale_price');
            $table->integer('qty');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->double('discount')->default(0);
            $table->double('coupon_discount')->default(0);
            $table->integer('tax');
            $table->string('courier')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('total_shipping_cost')->comment('shipping_cost * qty')->nullable();
            $table->double('total_price')->comment('sale_price * qty');
            $table->integer('grand_total');
            $table->integer('currency_id');
            $table->double('exchange_rate');
            $table->string('estimated_shipping_days')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
