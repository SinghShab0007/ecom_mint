<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 1, 54, '2022-03-23 09:25:40', '2022-03-23 09:25:40', NULL]
        ];

        foreach ($data as $d){
            DB::table('wishlist')->insert([
                'id' => $d[0],
                'user_id' => $d[1],
                'product_id' => $d[2],
                'created_at' => $d[3],
                'updated_at' => $d[4],
                'deleted_at' => $d[5],
            ]);
        }
    }
}
