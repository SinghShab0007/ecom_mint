<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id'=>1,
            'name'=>'super-admin',
            'email'=>'superadmin@maantheme.com',
            'phone'=>'01xxxxxxx',
            'password'=>bcrypt('superadmin22'),
            'avatar'=>'index.jpeg',
            'remember_token'=>'4OP3vjDScbnij0NmPgWRMy5Igioqywks24yCxR1PRnUSYY8O4XbkVdMoFOSt',
            'is_active'=>1,
            'created_at'=>'2021-06-04 06:17:34',
            'updated_at'=>'2021-10-03 03:41:55',
            'deleted_at'=>NULL,
        ]);
        DB::table('admins')->insert([
            'id' => 2,
            'name'=>'Admin',
            'email'=>'admin@maantheme.com',
            'phone'=>'01xxxxxxx',
            'password'=>bcrypt('admin22'),
            'avatar'=>'index.jpeg',
            'remember_token'=>'4OP3vjDScbnij0NmPgWRMy5Igioqywks24yCxR1PRnUSYY8O4XbkVdMoFOSt',
            'is_active'=>1,
            'created_at'=>'2021-06-04 06:17:34',
            'updated_at'=>'2021-10-03 03:41:55',
            'deleted_at'=>NULL,
        ]);
    }
}
