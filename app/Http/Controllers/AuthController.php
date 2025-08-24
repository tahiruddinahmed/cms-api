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
}
