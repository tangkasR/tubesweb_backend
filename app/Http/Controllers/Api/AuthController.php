<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    //
    public function register(Request $request){

        $registrationData = $request->all();
        

        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => ['required'],
            'nomorTelepon' => ['required']
        ]);

        if($validate->fails())
        return response(['message' => $validate->errors()], 400);
        $registrationData['password'] = bcrypt($request->password);
        $user = User::create($registrationData);

        event(new Registered($user)); 

        return response([
            'message' => 'Register Success',
            'user' => $user
        ],200);

    }
    public function login(Request $request){

        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

         if($validate->fails())

            return response(['message' => $validate->errors()], 400);
        
        if(!Auth::attempt($loginData))

            return response(['message' => 'Username atau Password masih salah'], 401);

        // $user = Auth::user();
        $user = Auth::user();
        if ($user->email_verified_at == NULL) {
            return response([
                'message' => 'Mohon Verifikasi Email Terlebih Dahulu!'
            ], 401);
        }
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function logout(Request $request){

        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ], 200);
        
    }
}
