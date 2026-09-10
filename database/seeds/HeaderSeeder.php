<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('headers')->insert(
            [
                'show_language'=>1,
                'show_currency'=>1,
                'enable_sticky_header'=>1,
                'enable_tracking_order'=>1,
                'show_help'=>1,
            ]
        );

    }
}
