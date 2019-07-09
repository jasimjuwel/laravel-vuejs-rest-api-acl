<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserManagement\UserRole;
use App\Http\Requests\UserRequest;
use App\User;
use Hash;
use Carbon\Carbon;
use Image;
use DB;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;


class UserRegistrationController extends Controller
{

    use SendsPasswordResetEmails;


    public function index(){
        $userRoleList = UserRole::where('status', '1')->get();
        return view('user_management.user_registration', compact('userRoleList'));
    }


    public function createUser(UserRequest $request){

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $imageData=$request->file('user_photo');
        if($imageData){
            $fileName = md5(str_random(30).time().'_'.$request->file('user_photo')).'.'.$request->file('user_photo')->getClientOriginalExtension();
            $request->file('user_photo')->move('uploads/userPhoto/',$fileName);
            $FilePath= url('/'). "/uploads/userPhoto/".$fileName;
            $input['user_photo'] = $FilePath;
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
            return redirect('admin-login')->with('successMsg', 'Your Registration Successfully Complete. You can log in now.');
        } else {
            return redirect(url('admin-login'))->withInput()->with('errorMsg', 'Something Error Found, Try Again.');
        }
    }

    public function showLinkRequestForm(){
        return view('user_management.forgot_password');
    }
}
