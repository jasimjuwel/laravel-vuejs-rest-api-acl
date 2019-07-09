<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('acl_modules')->truncate();
        DB::table('acl_modules')->insert(
            [
                ['id' => 1, 'module_name' => 'User Management', 'icon_class' => 'fa fa-share', 'created_at' => $time],
            ]
        );
    }
}
