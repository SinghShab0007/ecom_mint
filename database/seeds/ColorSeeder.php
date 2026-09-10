<?php

namespace Database\Seeders;

use App\Models\Backend\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Red', '#ff0000', 1, 1, NULL, null],
            [2, 'Blue', '#0000ff', 1, 1, NULL, null],
            [3, 'Green', '#008000', 1, 1, NULL, null],
            [4, 'Orange', '#ffa500', 1, 1, NULL, null],
            [5, 'White', '#ffffff', 0, 1, NULL, null],
            [6, 'Black', '#000000', 0, 1, NULL, NULL],
            [7, 'Yellow', '#ffff00', 1, 1, NULL, null],
            [8, 'Violet', '#ee82ee', 1, 1, NULL, null],
            [9, 'Silver', '#c0c0c0', 1, 1, NULL, null],
            [10, 'Grey', '#808080', 0, 1, NULL, NULL],
            [11, 'LightSlateGray', '#778899', 0, 1, NULL, NULL],
            [12, 'Maroon', '#800000', 0, 1, NULL, NULL],
            [13, 'Brown', '#a52a2a', 1, 1, NULL, null],
            [14, 'DarkBlue', '#00008b', 0, 1, NULL, NULL],
            [15, 'Navy blue', '#0b5394', 0, 1, NULL, NULL],
            [16, 'DeepSkyBlue', '#00bfff', 0, 1, NULL, NULL],
            [17, 'LightGreen', '#90ee90', 0, 1, NULL, NULL],
            [18, 'Purple', '#800080', 0, 1, NULL, NULL],
            [19, 'DarkViolet', '#9400d3', 0, 1, NULL, NULL],
            [20, 'Gold', '#ffd700', 0, 1, NULL, NULL],
            [21, 'LightYellow', '#ffffe0', 0, 1, NULL, NULL],
            [22, 'Khaki', '#f0e68c', 0, 1, NULL, NULL],
            [23, 'Violet', '#ee82ee', 0, 1, NULL, NULL],
            [24, 'MediumPurple', '#9370db', 0, 1, NULL, NULL],
            [25, 'Olive', '#808000', 0, 1, NULL, NULL],
            [26, 'DarkCyan', '#008b8b', 0, 1, NULL, NULL],
            [27, 'SkyBlue', '#87ceeb', 0, 1, NULL, NULL],
            [28, 'MediumSlateblue', '#7b68ee', 0, 1, NULL, NULL],
            [29, 'RosyBrown', '#bc8f8f', 0, 1, NULL, NULL],
            [30, 'Chocolate', '#d2691e', 0, 1, NULL, NULL],
            [31, 'Peru', '#cd853f', 0, 1, NULL, NULL],
            [32, 'DarkGoldenrod', '#b8860b', 0, 1, NULL, NULL],
        ];

        foreach($data as $d){
            Color::query()->create(['name'=>$d[1],'hex'=>$d[2],'display_in_search'=>$d[3],'is_active'=>$d[4],'updated_at'=>$d[5],'created_at'=>$d[6]]);
        }
    }
}
