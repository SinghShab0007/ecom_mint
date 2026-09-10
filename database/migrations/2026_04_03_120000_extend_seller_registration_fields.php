<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendSellerRegistrationFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('business_type')->nullable();
            $table->string('gstin', 32)->nullable();
            $table->timestamp('gstin_verified_at')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('pan', 20)->nullable();
            $table->string('business_name')->nullable();
            $table->string('shop_owner_name')->nullable();
            $table->string('shop_manager_name')->nullable();
            $table->string('shop_manager_mobile', 32)->nullable();
            $table->string('shop_no_complex')->nullable();
            $table->string('area')->nullable();
            $table->string('landmark')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('country', 120)->nullable();
            $table->string('shipping_phone', 32)->nullable();
            $table->json('deal_categories')->nullable();
            $table->boolean('data_consent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'business_type',
                'gstin',
                'gstin_verified_at',
                'referral_code',
                'pan',
                'business_name',
                'shop_owner_name',
                'shop_manager_name',
                'shop_manager_mobile',
                'shop_no_complex',
                'area',
                'landmark',
                'district',
                'state',
                'country',
                'shipping_phone',
                'deal_categories',
                'data_consent',
            ]);
        });
    }
}
