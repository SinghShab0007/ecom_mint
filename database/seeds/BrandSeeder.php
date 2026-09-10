<?php

namespace Database\Seeders;

use App\Models\Backend\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Scott Garza', '4hl0r4ylfKjO97tYPmERvZN9s41GAUwdvlJGlIVi.png', 'Sit tempor vel cum f', 'Tempore voluptatem', 'Culpa enim quia nihi', 4, 1, '2021-11-24 14:49:36', '2021-11-25 09:56:11', '2021-11-25 09:56:11'],
            [2, 'Bangladeshi', 'OkT3kXrSDkKq9sfMufxHWjLwDZxBJTwfyhbimyGw.jpg', 'Bangladeshi', NULL, 'Bangladeshi', 1, 0, '2021-11-25 09:55:58', '2022-01-24 11:02:02', NULL],
            [3, 'CK', 'Fx1ccgP75pnzhlwgtclyEOfrJ8dThNA0tK55NYQ0.png', 'CK', 'CK', 'CK', 2, 0, '2021-11-25 09:56:42', '2022-01-24 11:02:03', NULL],
            [4, 'samsang', 'W8xvzePB0r0uA7eiN37Jwea19GR3NFzGVYf8YIsj.jpg', 'Samsang', 'Samsang', 'Samsang', 4, 0, '2021-11-25 09:57:18', '2022-02-05 12:06:21', NULL],
            [5, 'Adidas', 'vLk1AmqkJXYis4p8MfvJ7kAOUaNPj74ledHxEB4y.jpg', 'Adidas', NULL, 'Adidas', 4, 0, '2021-11-25 09:57:42', '2022-02-05 12:09:43', NULL],
            [6, 'Cocacola', 'RumxdUuLta6IfvvpVZhfrEcTYtxDPIPp5EiM0vfq.jpg', 'Cocacola', NULL, 'Cocacola', 5, 0, '2021-11-25 09:58:24', '2022-02-05 12:09:44', NULL],
            [7, 'Hero', 'nTL7qH6hGXiMcuTMmdWqzYOqvccoR7rH2LSk0Kav.jpg', 'Hero', NULL, 'Hero', 6, 0, '2021-11-25 09:59:29', '2022-02-05 12:09:44', NULL],
            [8, 'Walton', 'E4lRSpVenL4cCR2jY5cHLiRjLeTIhe0bkaJfyHBU.jpg', 'Walton', 'Walton', 'Walton', 7, 0, '2021-11-25 10:01:31', '2022-02-05 12:09:46', NULL],
            [9, 'Rolex', '88jmw8h4zcC9XLcS4F7KJiR0oEy1LUSCaTWUIXbt.jpg', 'Rolex', NULL, 'Rolex', 8, 0, '2021-11-25 10:02:24', '2022-01-24 11:02:09', NULL],
            [10, 'Lemon', 'KcrqkbtMOdjRk6nLLPneBeTCbrJAec2SuPL6So5P.jpg', 'Lemon', NULL, 'Lemon', 9, 1, '2021-11-25 10:02:51', '2022-02-05 11:59:12', NULL],
            [11, 'HP', 'A8914rxGxrkZLjEZKYzbKOxGzfvK53Q9iRYGXl9X.jpg', 'HP', NULL, 'HP', 10, 1, '2021-11-25 10:03:10', '2022-02-05 11:59:09', NULL],
            [12, 'CHINA', 'VDevEAUzexQKCiSa23aAz5kWKjhypp7AooUX0irJ.png', 'useful', NULL, 'china', 10, 1, '2021-12-20 15:55:54', '2022-02-23 01:55:17', NULL],
            [13, 'indian', 'BDCTmqAiDUah24ELbteW7szyNHoCuUyh25M41Y38.png', 'titel', NULL, 'indian', 5, 0, '2021-12-28 14:37:35', '2022-02-23 01:54:58', NULL],
            [14, 'GUCCI', '5MrfrJ6NFz5BEA5xbIODg3uf8t5HsKcg94TtmTBQ.png', 'Ad eius quam placeat', 'Voluptas possimus d', 'gucci', 5, 1, '2022-01-24 10:59:16', '2022-02-23 01:54:28', NULL],
            [15, 'FENDI', '6B1kf6ZMXExXo5MvTHtKaHL75fpfJ0pGnV36rNwk.png', 'Minima voluptas enim', 'Reprehenderit qui vo', 'fendi', 6, 1, '2022-01-24 11:00:05', '2022-02-23 01:54:04', NULL],
            [16, 'SAMSUNG', 'xxP3u8QW4h0E0toZbegbZaAplP2iNAv2kTrMAAOJ.png', 'Excepteur commodi vo', 'Soluta excepturi ad', 'Autem ratione ut non', 4, 1, '2022-01-24 11:00:22', '2022-02-23 01:53:35', NULL],
            [17, 'DIAMOND WORLD', 'nqfWEewqxKHRWEVw0h0pW8rsjFVObgVdp8GXjsm8.png', 'Diamond Word', 'Eos ad ipsum id qui', 'diamond-world', 1, 1, '2022-01-24 11:00:51', '2022-02-23 01:53:20', NULL],
            [18, 'NOVA', 'GOZ8zYNSLc1mkpT9bg5KQAQjzWsN1nKxCZspuXWs.png', 'Error atque aut eos', 'Eu facilis enim et t', 'nova', 2, 1, '2022-01-24 11:01:12', '2022-02-23 01:53:02', NULL],
            [19, 'OGGI', 'JzIK5sDd0S3lac17WKgupEhZKjCRQUWNBT8DuikD.png', 'OGGI', 'Nihil nobis quidem t', 'oggi', 3, 1, '2022-01-24 11:01:39', '2022-02-23 01:52:25', NULL],
            [20, 'Martin Whitehead', 'rQmeC6bwkmozldnM4HtTzmO1RnJPs5eRbNqh5Vcl.png', 'Martin Whitehead', 'Possimus veniam qu', 'martin-whitehead', 34, 1, '2022-02-05 11:20:40', '2022-02-23 01:52:07', NULL],
            [21, 'test', 'RjCOr0uNlSC78KMHw5AI64ZbP2l6TYPPBq025V4f.png', 'Artificial-Flowerz', NULL, 'android-hacks', 1, 1, '2022-02-05 23:45:53', '2022-02-23 01:51:48', NULL],
        ];

        foreach ($data as $d){
            Brand::query()->create([
                'id' => $d[0],
                'name' => $d[1],
                'image' => $d[2],
                'meta_title' => $d[3],
                'meta_description' => $d[4],
                'slug' => $d[5],
                'order' => $d[6],
                'is_active' => $d[7],
                'created_at' => $d[8],
                'updated_at' => $d[9],
                'deleted_at' => $d[10],
            ]);
        }
    }
}
