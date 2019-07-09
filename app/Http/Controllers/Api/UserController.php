<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserManagement\UserRole;
use App\Http\Requests\UserRequest;
Use App\User;
use DB;
use JWTFactory;
use JWTAuth;
use Validator;
use Hash;


class UserController extends Controller
{

    public function index(Request $request)
    {
        //$userId = JWTAuth::parseToken()->authenticate()->id;
        $userList = User::with('role')->where('status', 1)->orderBy('id', 'ASC')->get();

        $userList = json_decode($userList, true);
        return view('api.user_list', compact('userList'));
        /*return response()->json([
            'code'      => 200,
            'response'  => 'success',
            'data'      => $userList
        ]);*/
    }


    public function create()
    {

    }

    public function store(Request $request)
    {

    }


    public function show()
    {

    }


    public function edit($id)
    {

        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User with id ' . $id . ' cannot be found'
            ], 400);
        }

        return view('api.edit_profile', compact('data'));

    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User  with id ' . $id . ' cannot be found'
            ], 400);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $updated = $data->fill($input)->save();

        if ($updated) {

            return redirect('api/api-user');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User could not be updated'
            ], 500);
        }
    }


    public function destroy($id)
    {

    }
}
