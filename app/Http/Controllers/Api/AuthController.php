<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request){
        return test();
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        
        $user = User::create($request->all());

        return response()->json([
                                'success' => true,
                                'data' => $user
                            ], 201);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if(Hash::check($request->password, $user->password)){
                
                // $token = JWTAuth::fromUser($user);

                $customExp = time() + (2 * 60 * 60);
                $token = JWTAuth::claims([
                    'exp'      => $customExp,
                    'username' => $user->name,
                ])->fromUser($user);
                
                return response()->json([
                    'success'   => true,
                    'data'      => $user,
                    'token'     => $token
                ]);
            }else{
                return response()->json([
                    'error'     => true,
                    'message'   => 'Password does not match'
                ], 401);
            }
        }else{
            return response()->json([
                'error'     => true,
                'message'   => 'Email does not exist'
            ], 401);
        }
    }
}
