<?php

namespace Database\Seeders;

use App\Models\Backend\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 5, 'Happy shop', 'Happy shop Best Quality', 'Free Shipping', 'lUqi4iG3v1fPZAVHDfzUpvb3tY2pLdKSxeRUYHrk.png', '_parent', 'banner', 'Best Deal Super Collection Best Deal Super Collection Best Deal Super Collection', '2025-12-04 23:00:00', 1, 1, 0, '2021-11-25 10:40:07', '2022-02-03 09:28:47', NULL],
            [2, 5, 'Best Deal', 'Best Deal Super Collection', '30% OFF', 'p1Yq2xoHLlhEarlsM72I9EG4uQvu79Gy31NXUie3.png', '_self', 'banner', 'Best Deal Collection Best Deal  Collection Best Deal Super Collection', '2025-01-29 23:00:00', 1, 1, 0, '2021-11-25 10:47:52', '2022-02-03 09:16:45', NULL],
            [3, 1, 'Home', NULL, '30% OFF', '2EhJst9MAEL0R0HMvtjefn8El2M14uN5oxrj1p4c.jpg', '_self', 'banner', NULL, '2021-12-30 23:00:00', 0, 0, 0, '2021-11-25 10:49:51', '2022-01-26 16:50:06', '2022-01-26 16:50:06'],
            [5, 7, 'Prime mall', 'Makeup Collection Makeup Collection Makeup Collection Makeup Collection', 'FREE', 'aPYMlzZICoW5KrMkonUR8W7SdCpouXUVujCrbhJE.jpg', '_self', 'banner', NULL, '2025-01-30 23:00:00', 1, 1, 0, '2021-11-25 10:55:58', '2022-01-26 15:26:26', '2022-01-26 15:26:26'],
            [6, 5, 'Power Thursday', 'Happy Shopping Happy Life', '20% OFF', 'z4uUksILqtx3hEMKuvLBfD9ntD1Ar8Jz5TBlSPkz.png', '_self', 'banner', 'Happy Shopping, Happy Life Happy Shopping, Happy Life Happy Shopping, Happy Life', '2028-12-20 23:00:00', 1, 1, 0, '2021-12-21 14:47:13', '2022-02-16 11:11:38', NULL],
            [7, 172, 'Sapiente maxime cons', 'Nam perferendis ea n', 'Qui pariatur Expedi', '29untoWiVPAPio2zY4Gy93GLdfIguu581lF74J3O.png', '_self', 'banner', 'Labore velit et adi', '2022-02-04 23:00:00', 1, 0, 0, '2022-02-05 11:27:05', '2022-02-05 11:27:39', '2022-02-05 11:27:39'],
            [8, 5, 'Prime Mall', 'Winter Fashion Collection', '45% OFF', 'EyuMRBrHtHqX7bSJx4rkEygBjviWpxT9iCnPHip1.png', '_self', 'banner', 'BEST COLLECTION BEST DEAL BEST COLLECTION BEST MALL', '2025-06-06 22:00:00', 1, 1, 0, '2022-02-05 23:51:33', '2022-02-16 10:59:36', NULL],
        ];

        foreach ($data as $d){
            Banner::query()->create([
                'id' => $d[0],
                'category_id'=>$d[1],
                'title'=>$d[2],
                'sub_title'=>$d[3],
                'offer_title'=>$d[4],
                'image'=>$d[5],
                'target'=>$d[6],
                'type'=>$d[7],
                'description'=>$d[8],
                'expire_at'=>$d[9],
                'is_active'=>$d[10],
                'publish_stat'=>$d[11],
                'total_click'=>$d[12],
                'created_at' => $d[13],
                'updated_at' => $d[14],
                'deleted_at' => $d[15],
            ]);
        }
    }
}
