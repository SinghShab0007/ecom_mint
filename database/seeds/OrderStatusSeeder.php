<?php

namespace Database\Seeders;

use App\Models\Frontend\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'PENDING',
            'CONFIRMED',
            'PROCESSING',
            'PICKED',
            'SHIPPED',
            'DELIVERED',
            'CANCELLED',
        ];

        foreach($data as $d){
            OrderStatus::query()->create(['name'=>$d]);
        }
    }
}
