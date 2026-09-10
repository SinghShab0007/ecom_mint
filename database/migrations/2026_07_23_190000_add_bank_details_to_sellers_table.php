<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankDetailsToSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'bank_account_number')) {
                $table->string('bank_account_number', 20)->nullable()->after('aadhaar');
            }
            if (!Schema::hasColumn('sellers', 'ifsc_code')) {
                $table->string('ifsc_code', 11)->nullable()->after('bank_account_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            foreach (['ifsc_code', 'bank_account_number'] as $column) {
                if (Schema::hasColumn('sellers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
