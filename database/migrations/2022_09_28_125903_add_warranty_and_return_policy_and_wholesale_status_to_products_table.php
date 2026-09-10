<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarrantyAndReturnPolicyAndWholesaleStatusToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('warranty')->nullable()->after('publish_stat');
            $table->string('return_policy')->nullable()->after('warranty');
            $table->integer('wholesale_status')->default(0)->comment('0=Unpublish | 1=Publish')->after('return_policy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('warranty','return_policy','wholesale_status');
        });
    }
}
