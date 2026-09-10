<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, NULL, 'Mybazar Personal Access Client', 'a4OoG2rct5toeQV6abQG5Cs827jVoAuEqAxcmPbp', NULL, 'http://localhost', 1, 0, 0, '2022-03-24 16:47:38', '2022-03-24 16:47:38'],
            [2, NULL, 'Mybazar Password Grant Client', '2kYrKvQ5XHmrdowDv8l6uALl22aIdTu4pJpXhQPR', 'users', 'http://localhost', 0, 1, 0, '2022-03-24 16:47:38', '2022-03-24 16:47:38']
        ];

        foreach ($data as $d){
            DB::table('oauth_clients')->insert([
                'id' => $d[0],
                'user_id'=> $d[1],
                'name'=> $d[2],
                'secret'=> $d[3],
                'provider'=> $d[4],
                'redirect'=> $d[5],
                'personal_access_client'=> $d[6],
                'password_client'=> $d[7],
                'revoked'=> $d[8],
                'created_at' => $d[9],
                'updated_at' => $d[10]
            ]);
        }
        DB::table('oauth_personal_access_clients')->insert([
            'id' => 1,
            'client_id'=>1,
            'created_at'=>'2022-03-24 16:47:38',
            'updated_at'=>'2022-03-24 16:47:38'
        ]);
    }
}
