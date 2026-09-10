<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('account')->nullable();
            $table->string('account_type')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->double('amount',8,2)->default(0.00);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
}
