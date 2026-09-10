<?php

namespace Database\Seeders;

use App\Models\Backend\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 7, 'Up to 60%', NULL, 1, '6CmISaf3WkkLwpi6DFkrJ5X49QvmWIRxvIXokUHY.png', '2023-12-30 23:00:00', NULL, 1600, 1, 1, '2021-11-25 12:43:47', '2022-01-23 11:07:55', NULL],
            [2, 10, 'Up to 50%', NULL, 1, 'ExM1sBM2AR7FSa3YcI9Idi88aDaqJgUSmheyCxps.png', '2023-12-30 23:00:00', NULL, 4990, 1, 1, '2021-11-25 12:49:42', '2022-01-22 10:46:26', NULL],
            [3, 29, 'Up to 30%', '1', 1, 'cgAmxtuX2bvLzOYjCmXlgv0t79tT2ia4lgwAwnhM.png', '2023-12-09 23:00:00', NULL, 2100, 1, 1, '2021-11-25 12:51:30', '2022-01-26 12:08:56', NULL],
            [4, 7, 'Up to 35%', '1', 1, 'ZiVCQZYdpdfJRcC0mgK0sKVLqtLra5AAbKEoTzMK.png', '2023-02-27 23:00:00', NULL, 2900, 1, 1, '2021-11-25 12:55:18', '2022-01-26 12:04:45', NULL],
            [5, 8, 'Up to 40%', NULL, 1, 'x1qB75EiJvbYEgUNVsRzfTkBLHneNj6vWT9ZEOoc.png', '2025-12-30 23:00:00', NULL, 3990, 1, 1, '2021-11-25 12:58:00', '2022-01-25 09:22:51', NULL],
            [6, 46, 'Men\'s Collection', '25% OFF', 2, 'xSBC6TlI8yruBK4AcH8bNTbnZpYKrlVZUvk6t8PD.png', '2022-12-30 23:00:00', NULL, 2100, 1, 1, '2021-11-25 13:01:54', '2022-01-26 12:26:47', NULL],
            [7, 14, 'Home Decor', '25% OFF', 2, '5QcaazBMmC2ynRltBfxsdtH8abDU67zqmDGlH8E4.png', '2023-12-20 23:00:00', NULL, 550, 1, 1, '2021-11-25 13:05:06', '2022-01-26 12:27:58', NULL],
            [8, 47, 'Women\'s Collection', '20% OFF', 2, 'wyXj7FY42rUW6u8tsXinPXlAC3ttmGHmCwwBIoFs.png', '2022-12-31 23:00:00', NULL, 1499, 1, 1, '2021-11-25 13:07:09', '2022-01-26 12:20:52', NULL],
            [9, 13, 'Hot offer', NULL, 3, 'GyqhkeK0wyh6p8UiJSb9PBddU2rb7qKOpY7sw20o.png', '2023-12-20 23:00:00', NULL, 299, 1, 1, '2021-11-25 13:56:12', '2022-02-12 22:25:45', NULL],
            [10, 47, 'Deal Of The Week', 'UP TO 40% OFF', 4, 'tJ5Z1GdkqkLeAfJfBTBxzGMwm7LoIyh2RnrH6RmG.png', '2022-12-31 23:00:00', NULL, 4000, 1, 1, '2021-11-25 14:02:10', '2022-02-05 14:55:28', NULL],
            [11, 30, 'Up to 50%', NULL, 1, 'uhSsWu3HApDry5z7BHJ9sTPLs2kjqWWGKpX9vDgm.png', '2023-12-30 23:00:00', NULL, 5000, 1, 1, '2021-12-20 17:27:30', '2022-02-05 23:46:12', '2022-02-05 23:46:12']
        ];

        foreach ($data as $d){
            Promotion::query()->create([
                'id' => $d[0],
                'product_id'=>$d[1],
                'title'=>$d[2],
                'label'=>$d[3],
                'position'=>$d[4],
                'image'=>$d[5],
                'expire_at'=>$d[6],
                'total_viewed'=>$d[7],
                'promotion_price'=>$d[8],
                'is_active'=>$d[9],
                'is_approve'=>$d[10],
                'created_at' => $d[11],
                'updated_at' => $d[12],
                'deleted_at' => $d[13]
            ]);
        }
    }
}
