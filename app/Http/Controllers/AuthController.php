<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController
{
    /**
     * Register a new user.
     * * http://localhost:8000/api/register
     */

     public function register(Request $request){
        $validator = validate($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Registration Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::create($validator->validated());
        $user->token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'ok' => true,
            'message' => 'Registration Success',
            'data' => $user
        ], 201);
     }


     /**
      * Login User
      * http://localhost:8000/api/login
      */

      public function login(Request $request){
        $validator = validate($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Login Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        if(auth()->attempt($validator->validated())){
            $user = auth()->user();
            $user->token = $user->createToken('auth-api')->accessToken;

            return response()->json([
                'ok' => true,
                'message' => 'Login Success',
                'date' => $user
            ], 200);
        }

        return response()->json([
            'ok' => false,
            'message' => 'Login Failed',
            'errors' => 'Invalid Credentials'
        ], 401);
    }

    /**
     * Check if user is authenticated
     * http://localhost:8000/api/checkToken
     */

     public function checkToken(Request $request){
        return response()->json([
            'ok' => true,
            'message' => 'Authenticated',
            'data' => $request->user()
        ], 200);
     }


     /**
      * Log out user
      * http://localhost:8000/api/logout
      */

      public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'ok' => true,
            'message' => 'Logout Success'
        ], 200);
     }
}
