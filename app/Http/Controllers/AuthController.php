<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // This method login a user and authenticate them with Sanctum
    public function login(Request $request)
    {
        // Validate the request
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // If the validation fails, return a 401 error
        if (!Auth::attempt($validate)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        // If the validation is successful, return a token
        $user = User::where('email', $validate['email'])->first();
        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    // This method register a new user
    public function register(Request $request)
    {
        // Validate the request
        $validate = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);
        // Create the user and return a token
        $user = User::create($validate);
        return response()->json([
            'data' => $user,
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
        ], 201);
    }
}
