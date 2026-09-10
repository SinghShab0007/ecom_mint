<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebAppearanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_appearances', function (Blueprint $table) {
            $table->id();
            $table->string('website_name');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('backend_logo')->nullable();
            $table->string('meta_title');
            $table->text('meta_desc');
            $table->string('keywords');
            $table->string('website_base_color')->nullable();
            $table->string('website_base_hover_color')->nullable();
            $table->longText('cookies_agreement_desc')->nullable();
            $table->tinyInteger('is_show_cookies_agreement')->default(1);
            $table->string('hotline_number');
            $table->string('email');
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('country',100)->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('get_in_touch', 300);
            $table->string('about_us', 300);
            $table->string('facebook_link', 200);
            $table->string('twitter_link', 200);
            $table->string('pinterest_link', 200);
            $table->string('instagram_link', 200);
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
        Schema::dropIfExists('web_appearances');
    }
}
