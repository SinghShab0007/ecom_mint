<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('offer_title');
            $table->string('sub_title')->nullable();
            $table->string('image');
            $table->string('target')->default('_self');
            $table->string('type');
            $table->string('description')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('publish_stat')->comment('0 = UnPublish, 1=Published');
            $table->bigInteger('total_click');
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
        Schema::dropIfExists('banners');
    }
}
