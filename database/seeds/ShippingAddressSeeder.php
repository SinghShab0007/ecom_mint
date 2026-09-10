<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 1, 'Fendi clark', 'Morokko city', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2022-03-23 09:53:45', '2022-03-23 09:53:45'],
            [2, 2, 'xavir', 'loyal city', NULL, NULL, NULL, NULL, NULL, 2, NULL, '2022-03-23 10:27:24', '2022-03-23 10:27:24'],
            [3, 3, 'Jerin', 'New york', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2022-03-23 10:53:38', '2022-03-23 10:53:38'],
        ];

        foreach ($data as $d){
            DB::table('shipping_addresses')->insert([
                'id' => $d[0],
                'user_id' => $d[1],
                'shipping_name' => $d[2],
                'address_line_one' => $d[3],
                'address_line_two' => $d[4],
                'shipping_mobile' => $d[5],
                'shipping_email' => $d[6],
                'shipping_town' => $d[7],
                'shipping_post' => $d[8],
                'shipping_country_id' => $d[9],
                'note' => $d[10],
                'created_at' => $d[11],
                'updated_at' => $d[12],
            ]);
        }
    }
}
