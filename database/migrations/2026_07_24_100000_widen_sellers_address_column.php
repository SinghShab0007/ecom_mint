<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WidenSellersAddressColumn extends Migration
{
    /**
     * `address` stores the shop address built by joining shop_no_complex, area,
     * landmark, city, district, state, country and post_code. Each of those is
     * varchar(125) on its own, so the joined value regularly overflowed the
     * varchar(125) address column and the save failed with
     * "Data too long for column 'address'".
     *
     * Raw statements are used so this does not require doctrine/dbal.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('sellers', 'address')) {
            DB::statement('ALTER TABLE `sellers` MODIFY `address` TEXT NULL');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sellers', 'address')) {
            DB::statement('ALTER TABLE `sellers` MODIFY `address` VARCHAR(125) NULL');
        }
    }
}
