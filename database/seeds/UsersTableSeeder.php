<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Hedley', 'Mckinney', 'Rerum obcaecati aliq', '8801XXXXXXXXX', 'customer@maantheme.com', '202111272206531.jpeg', 'customer', '$2y$10$g7G8NIrAns215xKq46gqm.F211UwngzCoXpWxOrG9UWvW/LtFD1o6', 1, '2000-08-31', 0, 1, 0, '2022-03-22 23:00:00', '708120', '2022-03-22 23:00:00', '2022-03-23 10:35:45', 1, NULL, '2022-03-22 23:00:00', '2022-03-23 10:35:45', NULL],
            [2, 'Thomas', 'Thomas', '', '66654512132', NULL, NULL, 'Thomas', '$2y$10$xLB54MOKIutVhTaXtrWYy.CEmW1PqFk6proa6kXJwcEV3oq7VJEdu', NULL, NULL, 0, 1, 0, NULL, '', NULL, '2022-03-23 10:44:57', 1, NULL, '2022-03-23 10:25:11', '2022-03-23 10:44:57', NULL],
            [3, 'James', 'mark', '', '6667845945', NULL, NULL, 'James', '$2y$10$TiFl.BH5rmnxfk3zJRNpL.5k78DQPNVoV7q2S1YBGvDSDyAh/aIAi', NULL, NULL, 0, 1, 0, NULL, '', NULL, NULL, 1, NULL, '2022-03-23 10:49:28', '2022-03-23 10:49:28', NULL],
        ];

        foreach ($data as $d){
            DB::table('users')->insert([
                'id' => $d[0],
                'first_name'=> $d[1],
                'last_name'=> $d[2],
                'address'=> $d[3],
                'mobile'=> $d[4],
                'email'=> $d[5],
                'image'=> $d[6],
                'username'=> $d[7],
                'password'=> $d[8],
                'gender'=> $d[9],
                'dob'=> $d[10],
                'stop_email'=> $d[11],
                'is_approve'=> $d[12],
                'is_suspended'=> $d[13],
                'email_verified_at'=> $d[14],
                'verification_code'=> $d[15],
                'verification_expire_at'=> $d[16],
                'last_login_datetime'=> $d[17],
                'is_active'=> $d[18],
                'remember_token' => $d[19],
                'created_at' => $d[20],
                'updated_at' => $d[21],
                'deleted_at' => $d[22],
            ]);
        }
    }
}
