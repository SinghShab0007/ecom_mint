<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 1, 'Hedley', 'Mckinney', 'Rajjastan', NULL, NULL, 1, '666125462132', 'customer@maantheme.com', 1, '2022-03-23 09:53:45', '2022-03-23 09:53:45', NULL],
            [2, 2, 'Thomas', 'Thomas', 'morokko', NULL, NULL, 3, '66654512132', NULL, 1, '2022-03-23 10:27:24', '2022-03-23 10:27:24', NULL],
            [3, 3, 'James', 'mark', 'Bangalor', NULL, NULL, 1, '6667845945', NULL, 1, '2022-03-23 10:53:38', '2022-03-23 10:53:38', NULL],
        ];

        foreach ($data as $d){
            DB::table('user_billings')->insert([
                'id' => $d[0],
                'user_id' => $d[1],
                'first_name' => $d[2],
                'last_name' => $d[3],
                'address_1' => $d[4],
                'post_code' => $d[5],
                'user_city' => $d[6],
                'country_id' => $d[7],
                'mobile' => $d[8],
                'email' => $d[9],
                'is_active' => $d[10],
                'created_at' => $d[11],
                'updated_at' => $d[12],
                'deleted_at' => $d[13],
            ]);
        }
    }
}
