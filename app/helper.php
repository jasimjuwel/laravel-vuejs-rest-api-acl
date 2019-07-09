<?php

use Illuminate\Support\Facades\DB;

function dateConvertFormtoDB($date)
{
    if (!empty($date)) {
        return date("Y-m-d", strtotime(str_replace('/', '-', $date)));
    }
}

function dateConvertDBtoForm($date)
{
    if (!empty($date)) {
        $date = strtotime($date);
        return date('d/m/Y', $date);
    }
}

function permissionCheck()
{

    $role_id = Auth::user()->role_id;
    return $result = array_column(json_decode(DB::table('acl_menus')->select('menu_url')
        ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
        ->where('acl_menu_permissions.role_id', '=', $role_id)
        ->where('menu_url', '!=', null)
        ->get()->toJson(), true), 'menu_url');
}

function showMenu()
{
    $role_id = Auth::user()->role_id;
    $modules = json_decode(DB::table('acl_modules')->get()->toJson(), true);

    $menus = json_decode(DB::table('acl_menus')
        ->select(DB::raw('acl_menus.id, acl_menus.menu_name, acl_menus.menu_url, acl_menus.parent_id, acl_menus.module_id'))
        ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
        ->where('acl_menu_permissions.role_id', $role_id)
        ->where('acl_menus.status', 1)
        ->whereNull('action')
        ->orderBy('acl_menus.id', 'ASC')
        ->get()->toJson(), true);


    $sideMenu = [];
    if ($menus) {
        foreach ($menus as $menu) {

            if (!isset($sideMenu[$menu['module_id']])) {
                $moduleId = array_search($menu['module_id'], array_column($modules, 'id'));

                $sideMenu[$menu['module_id']] = [];
                $sideMenu[$menu['module_id']]['id'] = $modules[$moduleId]['id'];
                $sideMenu[$menu['module_id']]['module_name'] = $modules[$moduleId]['module_name'];
                $sideMenu[$menu['module_id']]['icon_class'] = $modules[$moduleId]['icon_class'];
                $sideMenu[$menu['module_id']]['menu_url'] = '#';
                $sideMenu[$menu['module_id']]['parent_id'] = '';
                $sideMenu[$menu['module_id']]['module_id'] = $modules[$moduleId]['id'];
                $sideMenu[$menu['module_id']]['sub_menu'] = [];
            }
            if ($menu['parent_id'] == 0) {
                $sideMenu[$menu['module_id']]['sub_menu'][$menu['id']] = $menu;
                $sideMenu[$menu['module_id']]['sub_menu'][$menu['id']]['sub_menu'] = [];
            } else {

                array_push($sideMenu[$menu['module_id']]['sub_menu'][$menu['parent_id']]['sub_menu'], $menu);
            }

        }
    }

    return $sideMenu;
}