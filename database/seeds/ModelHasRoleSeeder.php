<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['7', 'App\\Modules\\Backend\\SellerManagement\\Entities\\Seller', '1'],
            ['7', 'App\\Modules\\Backend\\SellerManagement\\Entities\\Seller', '2'],
            ['7', 'App\\Modules\\Backend\\SellerManagement\\Entities\\Seller', '3'],
            ['7', 'App\\Modules\\Backend\\SellerManagement\\Entities\\Seller', '4'],
            ['7', 'App\\Modules\\Backend\\SellerManagement\\Entities\\Seller', '5'],
        ];

        foreach($data as $d){
            DB::table('model_has_roles')->insert([
                'role_id' => $d[0],
                'model_type'=>$d[1],
                'model_id'=>$d[2],
            ]);
        }
    }
}
