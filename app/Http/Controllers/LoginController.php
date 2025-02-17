<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $user->createToken('userAuthToken')->plainTextToken,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.'
        ], 200);
    }
}
