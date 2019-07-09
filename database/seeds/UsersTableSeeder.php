<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('users')->truncate();
        DB::table('users')->insert(
            [
                ['role_id' => '1', 'user_name' => 'Super Admin', 'email' => 'superadmin@mail.com', 'password' => bcrypt('123'),'user_photo' => 'http://localhost:8000/uploads/userPhoto/demo.png', 'remember_token' => str_random(10), 'created_at' => $time],
                ['role_id' => '2', 'user_name' => 'Admin', 'email' => 'admin@mail.com', 'password' => bcrypt('123'),'user_photo' => 'http://localhost:8000/uploads/userPhoto/demo.png', 'remember_token' => str_random(10), 'created_at' => $time],
                ['role_id' => '3', 'user_name' => 'SSL Support', 'email' => 'ssl_support@mail.com', 'password' => bcrypt('123'),'user_photo' => 'http://localhost:8000/uploads/userPhoto/demo.png', 'remember_token' => str_random(10), 'created_at' => $time],
                ['role_id' => '4', 'user_name' => 'Report User', 'email' => 'report_user@mail.com', 'password' => bcrypt('123'),'user_photo' => 'http://localhost:8000/uploads/userPhoto/demo.png', 'remember_token' => str_random(10), 'created_at' => $time],
                ['role_id' => '5', 'user_name' => 'Balance User', 'email' => 'balance_user@mail.com', 'password' => bcrypt('123'),'user_photo' => 'http://localhost:8000/uploads/userPhoto/demo.png', 'remember_token' => str_random(10), 'created_at' => $time],
            ]
        );
    }
}
