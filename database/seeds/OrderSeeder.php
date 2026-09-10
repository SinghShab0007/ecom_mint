<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'INV1', NULL, NULL, 340, 6612, 13, 1, 'Fendi clark', 'Morokko city', NULL, '66664551533', 'customer@maantheme.com', NULL, NULL, 1, NULL, 'cod', 1, 'Hedley', 'Mckinney', 'Rajjastan', NULL, NULL, 1, '666125462132', 'customer@maantheme.com', '2022-03-23 09:53:46', '2022-03-23 09:53:46'],
            [2, 'INV2', NULL, NULL, 720, 22300, 13, 1, 'Devid warner', 'Australia', NULL, '66612545478', 'customer@maantheme.com', NULL, NULL, 16, NULL, 'cod', 1, 'Hedley', 'Mckinney', 'Rajjastan', NULL, NULL, 1, '666125462132', 'customer@maantheme.com', '2022-03-23 09:59:31', '2022-03-23 09:59:31'],
            [3, 'INV3', NULL, NULL, 209, 10740, 13, 1, 'Brand lara', 'Singapur', NULL, '6668921232', 'customer@maantheme.com', NULL, NULL, 2, NULL, 'cod', 1, 'Hedley', 'Mckinney', 'Rajjastan', NULL, NULL, 241, '666125462132', 'customer@maantheme.com', '2022-03-23 10:05:08', '2022-03-23 10:05:08'],
            [4, 'INV4', NULL, NULL, 2660, 97050, 13, 1, 'xavir', 'loyal city', NULL, '66654512132', NULL, NULL, NULL, 2, NULL, 'cod', 2, 'Thomas', 'Thomas', 'morokko', NULL, NULL, 3, '66654512132', NULL, '2022-03-23 10:27:24', '2022-03-23 10:40:36'],
            [5, 'INV5', NULL, NULL, 408, 193075, 13, 1, 'Morgan', 'doha', NULL, '66654512132', NULL, NULL, NULL, 77, NULL, 'cod', 2, 'Thomas', 'Thomas', 'morokko', NULL, NULL, 22, '66654512132', NULL, '2022-03-23 10:30:34', '2022-03-23 10:30:34'],
            [6, 'INV6', NULL, NULL, 760, 40570, 13, 1, 'Jerin', 'New york', NULL, '6667845945', NULL, NULL, NULL, 1, NULL, 'cod', 3, 'James', 'mark', 'Bangalor', NULL, NULL, 1, '6667845945', NULL, '2022-03-23 10:53:38', '2022-03-23 10:53:38'],
            [7, 'INV7', NULL, NULL, 1104, 271950, 13, 1, 'Usain Bolt', 'America', NULL, '6667845945', NULL, NULL, NULL, 253, NULL, 'cod', 3, 'James', 'mark', 'Bangalor', NULL, NULL, 253, '6667845945', NULL, '2022-03-23 11:00:52', '2022-03-23 11:00:52']
        ];

        foreach ($data as $d){
            DB::table('orders')->insert([
                'id'=>$d[0],
                'order_no'=>$d[1],
                'discount'=>$d[2],
                'tax'=>$d[3],
                'shipping_cost'=>$d[4],
                'total_price'=>$d[5],
                'currency_id'=>$d[6],
                'exchange_rate'=>$d[7],
                'shipping_name'=>$d[8],
                'shipping_address_1'=>$d[9],
                'shipping_address_2'=>$d[10],
                'shipping_mobile'=>$d[11],
                'shipping_email'=>$d[12],
                'shipping_post'=>$d[13],
                'shipping_town'=>$d[14],
                'shipping_country_id'=>$d[15],
                'shipping_note'=>$d[16],
                'payment_by'=>$d[17],
                'user_id'=>$d[18],
                'user_first_name'=>$d[19],
                'user_last_name'=>$d[20],
                'user_address_1'=>$d[21],
                'user_post_code'=>$d[22],
                'user_city'=>$d[23],
                'user_country_id'=>$d[24],
                'user_mobile'=>$d[25],
                'user_email'=>$d[26],
                'created_at'=>$d[27],
                'updated_at'=>$d[28]
            ]);
        }

    }
}
