<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\UserManagement\UserRole;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
Use App\User;
use Hash;
use Carbon\Carbon;
use Image;
use DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return User::with('role')->withTrashed()->orderBy('id', 'desc')->paginate($request->perPage);
        }

        $userRoleList = UserRole::where('status', '1')->get();
        return view('user_management.user', compact('userRoleList'));
    }


    public function create()
    {
        //
    }


    public function store(UserRequest $request)
    {

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['created_by'] = Auth::user()->id;

        $imageData = $request->get('user_photo');
        if ($imageData) {
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('user_photo'))->save(public_path('/uploads/userPhoto/') . $fileName);
            $filePath = url('/') . "/uploads/userPhoto/" . $fileName;
            $input['user_photo'] = $filePath;
        }

        try {
            DB::beginTransaction();

            User::create($input);

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'User successfully Inserted !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'User is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return User::FindOrFail($id);
    }

    public function update(UserRequest $request, $id)
    {
        $data = User::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        $imageData = $request->get('user_edit_photo');
        if ($imageData) {
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('user_edit_photo'))->save(public_path('/uploads/userPhoto/') . $fileName);
            $FilePath = url('/') . "/uploads/userPhoto/" . $fileName;
            $input['user_photo'] = $FilePath;

            if ($data->user_photo != '' && file_exists('uploads/userPhoto/' . $data->user_photo)) {
                unlink('uploads/userPhoto/' . $data->user_photo);
            }
        }

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
            return response()->json(['status' => 'success', 'message' => 'User successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'User is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }


    public function destroy($id)
    {
        $data = User::FindOrFail($id);
        try {
            $data->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }
        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'User successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
