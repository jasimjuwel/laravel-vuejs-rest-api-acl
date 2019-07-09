<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;


class LoginController extends Controller
{
    public function jwtLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            //return response()->json($validator->errors());
            return response()->json([
                'code' => 422,
                'response' => 'Validation error.',
                'errors' => apiValidateError($validator->errors())
            ]);
        }

        $credentials = $request->only('email', 'password');


        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'code' => 404,
                    'response' => 'error',
                    'errors' => ['massage' => 'invalid email/ or password.']
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'code' => 500,
                'response' => 'error',
                'errors' => ['massage' => 'failed to create token.']
            ]);
        }


       // $user = JWTAuth::toUser($token);
        $user = JWTAuth::User($token);
        $user['token'] = $token;

        return response()->json([
            'code' => 200,
            'response' => 'success',
            'expires' => auth('api')->factory()->getTTL() * 60,
            'data' => $user
        ]);
    }

    public function login(){
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'token' => $token,
            'expires' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
