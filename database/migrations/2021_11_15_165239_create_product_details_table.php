<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->tinyInteger('is_free_shipping');
            $table->tinyInteger('is_flat_rate');
            $table->tinyInteger('is_product_wise_shipping');
            $table->tinyInteger('is_quantity_multiply');
            $table->integer('warning_quantity')->default(5);
            $table->tinyInteger('is_show_stock_quantity');
            $table->tinyInteger('is_show_stock_with_text_only');
            $table->tinyInteger('is_hide_stock');
            $table->tinyInteger('is_cash_on_delivery');
            $table->tinyInteger('is_featured');
            $table->tinyInteger('is_todays_deal');
            $table->tinyInteger('is_best_sell');
            $table->tinyInteger('is_flash_deal')->default(0);
            $table->string('inside_shipping_days')->nullable(); // Shipping days inside city.
            $table->string('outside_shipping_days')->nullable(); // Shipping days outside city.
            $table->double('vat')->nullable();
            $table->double('tax')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
}
