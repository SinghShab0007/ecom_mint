<?php

namespace Database\Seeders;

use App\Models\Backend\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'About Us', 'about-us', '_self', 0, 1, 1, 0, 1, '2021-11-20 20:42:29', '2022-02-17 09:09:01', NULL],
            [2, 'New Arrivals', 'new-arrivals', '_self', 1, 0, 0, 0, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [3, 'Trends', 'trends', '_self', 1, 1, 0, 0, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [4, 'All Brands', 'brands', '_self', 1, 0, 0, 0, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [5, 'All Shop', 'shop', '_self', 1, 0, 0, 0, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [6, 'Support', 'support', '_self', 0, 1, 1, 0, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [7, 'Live Support', 'live-support', '_self', 0, 1, 0, 1, 1, NULL, NULL, NULL],
            [13, 'Privacy & Policy', 'privacy-n-policy', '_self', 0, 1, 0, 1, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [14, 'Return Policy', 'order-n-returns', '_self', 0, 1, 0, 1, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [16, 'Our Sitemap', 'sitemap', '_self', 0, 0, 0, 1, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [18, 'Helpline', 'helpline', '_self', 0, 1, 1, 0, 1, NULL, '2022-02-17 09:10:25', NULL],
            [19, 'Customer Services', 'customer-services', '_self', 0, 1, 0, 1, 1, NULL, NULL, NULL],
            [20, 'Cancellation Policy', 'cancellation_policy', '_self', 0, 1, 0, 1, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
            [21, 'Our Blog', 'our-blog', '_self', 0, 1, 0, 1, 1, '2021-11-20 20:42:29', '2021-11-20 20:42:29', NULL],
        ];

        foreach($data as $d){
            Menu::query()->create([
                'id' => $d[0],
                'name'=>$d[1],
                'url'=>$d[2],
                'target'=>$d[3],
                'is_header_menu'=>$d[4],
                'is_footer_menu'=>$d[5],
                'is_quick_link'=>$d[6],
                'is_informatics'=>$d[7],
                'is_active'=>$d[8],
                'created_at'=>$d[9],
                'updated_at'=>$d[10],
                'deleted_at' => $d[11],
            ]);
        }
    }
}
