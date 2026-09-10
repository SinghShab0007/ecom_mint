<?php

namespace Database\Seeders;

use App\Models\Frontend\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'S', 0, 1, NULL, NULL],
            [2, 'M', 0, 1, NULL, NULL],
            [3, 'L', 0, 1, NULL, NULL],
            [4, 'XL', 0, 1, NULL, NULL],
            [5, 'XXL', 0, 1, NULL, NULL],
        ];

        foreach ($data as $d){
            Size::query()->create(['name'=>$d[1],'display_in_search'=>$d[2],'is_active'=>$d[3]]);
        }
    }
}
