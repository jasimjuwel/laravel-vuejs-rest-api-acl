<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Auth;
use Session;
use Validator;
use App\User;


class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended(url('dashboard'));
        }
        return view('login');
    }

    public function Auth(LoginRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $userStatus = Auth::User()->status;
            if ($userStatus == '1') {

                $user_data = [
                    "id" => Auth::user()->id,
                    "email" => Auth::user()->email,
                    "user_name" => Auth::user()->user_name,
                    "role_id" => Auth::user()->role_id
                ];

                session()->put('logged_session_data', $user_data);
                return redirect()->intended(url('/dashboard'));
            } else {
                Auth::logout();
                Session::flush();
                return redirect(url('admin-login'))->withInput()->with('errorMsg', 'You are temporary blocked. please contact to admin');
            }
        } else {
            return redirect(url('admin-login'))->withInput()->with('errorMsg', 'Incorrect username or password. Please try again.');
        }
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('admin-login')->with('successMsg', 'Successfully Logged Out');
    }
}
