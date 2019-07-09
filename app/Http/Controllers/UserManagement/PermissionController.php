<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use DB;
use App\Models\UserManagement\UserRole;

class PermissionController extends Controller
{
    public function index()
    {
        $roleList = UserRole::get();
        return view('user_management.permission', compact('roleList'));
    }

    public function getAllMenus(Request $request)
    {
        $role_id = $request->role_id;
        $permissions = json_decode(DB::table('acl_menus')
            ->select(DB::raw('acl_menus.id, acl_menus.menu_name, acl_menus.menu_url, acl_menus.parent_id, acl_menus.module_id,acl_menu_permissions.menu_id'))
            ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
            ->where('acl_menu_permissions.role_id', '=', $role_id)
            ->get()->toJson(), true);

        $allMenus = json_decode(DB::table('acl_menus')
            ->select(DB::raw('acl_menus.*,acl_modules.module_name,acl_modules.icon_class'))
            ->join('acl_modules', 'acl_modules.id', '=', 'acl_menus.module_id')
            ->where('acl_menus.status', '=', 1)
            ->whereNotNull('menu_url')
            // ->whereNull('action')
            ->orderBy('module_id')
            //   ->orderBy('id')
            ->get()->toJSON(), true);


        $subMenu = [];

        $arrayFormat = [];
        foreach ($allMenus as $allMenu) {
            $hasPermission = array_search($allMenu['id'], array_column($permissions, 'menu_id'));

            if (gettype($hasPermission) == 'integer') {
                $allMenu['hasPermission'] = 'yes';
            } else {
                $allMenu['hasPermission'] = 'no';
            }

            if (!empty($allMenu['action'])) {
                $subMenu[$allMenu['parent_id']][] = $allMenu;
            }

            if ($allMenu['action'] == '') {
                $arrayFormat[$allMenu['module_name']][$allMenu['menu_name']] = $allMenu;
            }
        }

        return ['arrayFormat' => $arrayFormat, 'subMenu' => $subMenu];
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'role_id' => 'required'
        ], [
            'role_id.required' => 'The User role field is required.',
        ]);

        try {
            DB::beginTransaction();

            $role_id = $request->role_id;
            $deleteMenu = DB::table('acl_menu_permissions')->where('role_id', '=', $role_id)->delete();
            $menu = count($request->menu_id);


            if ($menu == 0) {
                DB::commit();
                return redirect()->back()->with('success', 'Role permission update successfully');
            }

            for ($i = 0; $i < $menu; $i++) {
                $getParentId = DB::table('acl_menus')->where('id', '=', $request->menu_id[$i])->first();
                if ($getParentId->parent_id != 0) {
                    $checkParentMenuDuplicate = DB::table('acl_menu_permissions')->where('role_id', $role_id)->where('menu_id', $getParentId->parent_id)->first();
                    if (!$checkParentMenuDuplicate) {
                        $insertParentMenu = array(
                            "menu_id" => $getParentId->parent_id,
                            "role_id" => $role_id,
                        );
                        DB::table('acl_menu_permissions')->insert($insertParentMenu);
                    }
                }
                $insertMenu = array(
                    "menu_id" => $request->menu_id[$i],
                    "role_id" => $role_id,
                );
                DB::table('acl_menu_permissions')->insert($insertMenu);
            }

            DB::commit();

            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            $notification = array(
                'message' => 'Role Permission Update Successfully.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Something Error Found !, Please try again.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }
}
