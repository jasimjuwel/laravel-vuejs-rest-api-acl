<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('acl_menus')->truncate();
        DB::table('acl_menus')->insert(
            [
                //User Section
                array('id' => 1, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Users', 'menu_url' => 'user.index', 'module_id' => '1', 'created_at' => $time),
                array('id' => 2, 'parent_id' => 1, 'action' => 1, 'menu_name' => 'Add', 'menu_url' => 'user.store', 'module_id' => '1', 'created_at' => $time),
                array('id' => 3, 'parent_id' => 1, 'action' => 1, 'menu_name' => 'Edit', 'menu_url' => 'user.edit', 'module_id' => '1', 'created_at' => $time),
                array('id' => 4, 'parent_id' => 1, 'action' => 1, 'menu_name' => 'Delete', 'menu_url' => 'user.destroy', 'module_id' => '1', 'created_at' => $time),

                //Role Section
                array('id' => 5, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Roles', 'menu_url' => 'role.index', 'module_id' => '1', 'created_at' => $time),
                array('id' => 6, 'parent_id' => 5, 'action' => 5, 'menu_name' => 'Add', 'menu_url' => 'role.store', 'module_id' => '1', 'created_at' => $time),
                array('id' => 7, 'parent_id' => 5, 'action' => 5, 'menu_name' => 'Edit', 'menu_url' => 'role.edit', 'module_id' => '1', 'created_at' => $time),
                array('id' => 8, 'parent_id' => 5, 'action' => 5, 'menu_name' => 'Delete', 'menu_url' => 'role.destroy', 'module_id' => '1', 'created_at' => $time),

                array('id' => 9, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'User Role Permission', 'menu_url' => 'menu-permission.index', 'module_id' => '1', 'created_at' => $time),
                array('id' => 10, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Change Password', 'menu_url' => 'change-password.index', 'module_id' => '1', 'created_at' => $time),

                //Department Section
                array('id' => 11, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Department', 'menu_url' => 'department.index', 'module_id' => '1', 'created_at' => $time),
                array('id' => 12, 'parent_id' => 11, 'action' => 11, 'menu_name' => 'Add', 'menu_url' => 'department.store', 'module_id' => '1', 'created_at' => $time),
                array('id' => 13, 'parent_id' => 11, 'action' => 11, 'menu_name' => 'Edit', 'menu_url' => 'department.edit', 'module_id' => '1', 'created_at' => $time),
                array('id' => 14, 'parent_id' => 11, 'action' => 11, 'menu_name' => 'Delete', 'menu_url' => 'department.destroy', 'module_id' => '1', 'created_at' => $time),

            ]
        );
    }
}
