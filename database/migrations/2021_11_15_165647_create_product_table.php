<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name');
            $table->string('unit');
            $table->boolean('is_manage_stock')->default(1);
            $table->text('tags')->nullable();
            $table->integer('minimum_qty');
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            $table->tinyInteger('is_refundable')->default(0);
            $table->text('attributes')->nullable();
            $table->double('unit_price');
            $table->double('purchase_price')->nullable();
            $table->double('sale_price');
            $table->integer('quantity');
            $table->double('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->integer('shipping_cost')->default(0); // Inside City
            $table->integer('outside_shipping_cost')->default(0); // Outside City
            $table->integer('shipping_cost')->nullable();
            $table->longText('description')->nullable();
            $table->string('pdf_specification')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('slug');
            $table->bigInteger('total_viewed')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->integer('publish_stat')->comment('0 = UnPublish, 1= Draft, 2=Published');
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
        Schema::dropIfExists('products');
    }
}
