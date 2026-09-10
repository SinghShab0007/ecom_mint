<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('order');
            $table->string('icon')->nullable()->comment('32 X 32');
            $table->string('banner')->nullable()->comment('200 X 200');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('slug');
            $table->double('commission_rate');
            $table->tinyInteger('show_in_home');
            $table->tinyInteger('for_menu')->default(0);
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('categories');
    }
}
