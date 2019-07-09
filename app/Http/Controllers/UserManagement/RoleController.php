<?php

namespace App\Http\Controllers\UserManagement;

use App\Models\UserManagement\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        $theadColoumn = UserRole::select('role_name AS Role Name', 'status as Status')->limit(1)->get()->toArray();
        //dd(array_keys($theadColoumn[0]));

        if ($request->ajax()) {

            $query = UserRole::select('id', 'role_name', 'status')->orderBy('id', 'desc');

            if ($request->role_id) {
                $query->where('id', $request->role_id);
            }
            if ($request->status) {
                $query->where('status', $request->status);
            }
            //$theadColoumn = array('Role Name', 'Status');
            $queryResult = $query->paginate($request->perPage);
            $resultData = array(
                'theadColoumn' => array_keys($theadColoumn[0]),
                'data' => $queryResult,
            );
            return $resultData;
        }

        $userRoleList = UserRole::get();
        return view('user_management.role', compact('userRoleList'));
    }

    public function create()
    {

    }

    public function store(RoleRequest $request)
    {

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();

            UserRole::create($input);

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'User Role successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'User Role is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        return UserRole::FindOrFail($id);
    }

    public function update(RoleRequest $request, $id)
    {

        $data = UserRole::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();

            $data->update($input);

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'User Role successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'User Role is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }


    public function destroy($id)
    {
        $data = UserRole::FindOrFail($id);
        try {
            $data->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }


        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'User Role successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
