<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('shipping_name');
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('shipping_mobile')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_town')->nullable();
            $table->string('shipping_post')->nullable();
            $table->integer('shipping_country_id')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('shipping_addresses');
    }
}
