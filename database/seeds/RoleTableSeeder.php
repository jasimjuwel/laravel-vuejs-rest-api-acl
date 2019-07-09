<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('user_roles')->truncate();
        DB::table('user_roles')->insert(
            [
                ['role_name' => 'Super Admin', 'created_at' => $time],
                ['role_name' => 'Admin', 'created_at' => $time],
                ['role_name' => 'SSL Support', 'created_at' => $time],
                ['role_name' => 'Report User', 'created_at' => $time],
                ['role_name' => 'Balance User', 'created_at' => $time],
            ]

        );
    }
}
