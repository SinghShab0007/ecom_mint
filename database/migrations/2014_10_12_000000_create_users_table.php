<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->string('mobile')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('gender')->nullable()->comment('0 = other, 1 = male, 2 = female');
            $table->date('dob')->nullable();
            $table->tinyInteger('stop_email')->nullable();
            $table->tinyInteger('is_approve')->default(1);
            $table->tinyInteger('is_suspended')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->timestamp('verification_expire_at')->nullable();
            $table->timestamp('last_login_datetime')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
