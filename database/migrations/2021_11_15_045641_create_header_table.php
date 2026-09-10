<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('show_language')->default(1);
            $table->tinyInteger('show_currency')->default(1);
            $table->tinyInteger('enable_sticky_header')->default(1);
            $table->tinyInteger('enable_tracking_order')->default(1);
            $table->tinyInteger('show_help')->default(1);
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
        Schema::dropIfExists('headers');
    }
}
