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

    public function update(Request $request)
    {
        $user = $request->user(); // Get authenticated user

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            // add more fields if needed
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->update($request->only(['username', 'firstName', 'lastName']));

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }

    public function updatePicture(Request $request)
    {
        \Log::info($request->all());
        // Get the authenticated user
        $user = $request->user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Check if the request contains the profile picture
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');

            // Store the image in the 'profile_pictures' directory within 'public'
            $imagePath = $image->store('profile_pictures', 'public');

            // Optionally delete the old profile picture if it exists
            if ($user->profile_picture) {
                // Ensure the old file is removed from storage
                \Storage::disk('public')->delete($user->profile_picture);
            }

            // Update the user's profile picture field in the database
            $user->profile_picture = $imagePath;
            $user->save();
        }

        // Return a success response
        return response()->json([
            'message' => 'Profile picture updated successfully.',
            'user' => $user,
        ]);
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

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('username', 'like', '%' . $query . '%')->get();

        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::with(['outfits.head', 'outfits.top', 'outfits.bottom', 'outfits.footwear'])
            ->findOrFail($id);

        return response()->json($user);
    }



}
