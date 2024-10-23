<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create the user
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Check if the user exists (by 'username')
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Generate a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Set the token in an HTTP-only cookie
        return response()->json([
            'message' => 'Login successful.'
        ])->cookie(
            'auth_token', // Cookie name
            $token, // Token value
            60 * 24, // Expiration time in minutes (e.g., 1 day)
            '/', // Path
            null, // Domain (null will use the default)
            true, // Secure (set to true if you're using HTTPS)
            true, // HttpOnly (true ensures it's not accessible via JavaScript)
            false // SameSite None (you can set this to 'strict' or 'lax')
        );
    }


    public function logout(Request $request)
    {
        // Revoke the user's current access token
        $request->user()->currentAccessToken()->delete();

        // Clear the authentication token cookie
        return response()->json([
            'message' => 'Logged out successfully.'
        ])->withCookie(cookie()->forget('auth_token')); // Forget the auth_token cookie
    }


}
