<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class UserPermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role_id = session('logged_session_data.role_id');
        if (isset($role_id)) {

            $namedRoute = \Route::currentRouteName();
            $current_url_check = DB::table('acl_menus')->select('menu_url')->where('menu_url', $namedRoute)->where('status', 1)->get()->toArray();
            if ($namedRoute) {
                if ($current_url_check) {
                    if (!in_array($namedRoute, $current_url_check)) {
                        $permissionCheck = DB::table('acl_menus')
                            ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
                            ->where('role_id', $role_id)
                            ->where('menu_url', $namedRoute)
                            ->get()->toArray();
                        if (empty($permissionCheck) || count($permissionCheck) < 0) {
                            return response()->view('errors.404', [], 404);
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
