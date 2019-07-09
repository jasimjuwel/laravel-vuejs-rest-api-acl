<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Password;
use Auth;


class PasswordResetController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo = '/admin-login';


    public function __construct()
    {

    }

    public function showResetForm(Request $request, $token = null) {
        return view('user_management.reset_password')
            ->with(['token' => $token, 'email' => $request->email]
            );
    }



    protected function guard()
    {
        return Auth::guard('users');
    }
    
    protected function broker() {
        return Password::broker('users');
    }

}
