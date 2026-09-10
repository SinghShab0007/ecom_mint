<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('title');
            $table->string('label')->nullable();
            $table->integer('position');
            $table->string('image');
            $table->timestamp('expire_at')->nullable();
            $table->bigInteger('total_viewed')->nullable();
            $table->double('promotion_price');
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_approve');
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
        Schema::dropIfExists('promotions');
    }
}
