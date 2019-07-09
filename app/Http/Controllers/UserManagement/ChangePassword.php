<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Auth;
use DB;

class ChangePassword extends Controller
{

    public function index()
    {
        return view('user_management.change_password');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3',
        ]);

        $user = Auth::user();

        if (Hash::check($request->get('current_password'), Auth::user()->password) && $request->get('password') == $request->get('password_confirmation')) {
            //Change Password
            $user->password = Hash::make($request->get('password'));
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Password changed successfully !']);


        } else {
            return response()->json(['status' => 'error', 'message' => 'Your current password does not matches with the password you provided. Please try again.\'']);
        }
    }
}
