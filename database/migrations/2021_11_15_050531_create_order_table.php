<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->integer('discount')->nullable();
            $table->double('vat')->default(0);
            $table->boolean('is_manage_stock')->default(1);
            $table->double('paid_amount', 2)->default(0);
            $table->string('payment_status')->default('unpaid'); // paid, unpaid
            $table->integer('shipping_cost')->default(0);
            $table->integer('total_price')->default(0);
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('exchange_rate')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_address_1');
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_mobile')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_post')->nullable();
            $table->string('shipping_town')->nullable();
            $table->unsignedBigInteger('shipping_country_id')->nullable();
            $table->text('shipping_note')->nullable();
            $table->string('payment_by')->comment('COD | Mobile Banking');
            $table->unsignedBigInteger('user_id');
            $table->string('user_first_name')->nullable();
            $table->string('user_last_name')->nullable();
            $table->string('user_address_1')->nullable();
            $table->string('user_post_code')->nullable();
            $table->string('user_city')->nullable();
            $table->unsignedBigInteger('user_country_id')->nullable();
            $table->string('user_mobile')->nullable();
            $table->string('user_email')->nullable();
            $table->text('meta')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
