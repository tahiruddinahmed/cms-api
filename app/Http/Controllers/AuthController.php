<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        // chech if the user is already exists 
        $user = User::where('email', $request->email)->first();
        if($user) {
            throw ValidationException::withMessages([
                'user' => 'You already have an account'
            ]);
        }

        // Hash the password 
        Hash::make($request->password);

        // insert a entry in the database 
        $user = User::create($data);

        // generate a token - direct login in 
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => 'Congrats, You are success fully logged in',
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Login
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // check user 
        $user = User::where('email', $request->email)->first();
        
        if(!$user) {
            throw ValidationException::withMessages([
                'email' => 'invalid credentials'
            ]);
        }

        // check password 
        if(!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'invalid credentials'
            ]);
        }

        // create a token 
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'Success' => 'You are now logged in -',
            'Token' => $token

        ]);
    }


    /**
     * Log out - revoking tokens
     */
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => "Logged out"
        ]);
    }
}
