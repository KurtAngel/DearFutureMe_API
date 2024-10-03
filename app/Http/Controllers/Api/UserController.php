<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api;
use App\Http\Resources\UserResource;

class UserController
{
    public function register(Request $request) {
        $user = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'age' => 'required|integer'
        ]);
    
        $user = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
            'age' => $user['age']
        ]);

        return response()->json($user, 201);
    }

    public function index(Request $request) {
        $users = User::get(); // Retrieve all users
        return UserResource::collection($users);
    }

    public function destroy($id) {
        $user = User::find($id);
        // return User::delete();
        $user->delete(); // Delete the specific user

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
    // public function login(Request $request) {
    //     $user = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6',
    //         'age' => 'required|integer'
    //     ]);

    //     $user = User::get([
    //         'name' => $user['name'],
    //         'email' => $user['email'],
    //         'password' => Hash::make($user['password']),
    //         'age' => $user['age']
    //     ]);

    //     return response()->json($user, 201);
    // }
    public function login(Request $request) {
        // Validate the incoming request
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    
        // Retrieve the user by email
        $user = User::where('email', $validatedData['email'])->first();
    
        // Check if the user exists and verify the password
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        // Optionally, create a token for the user (if using API tokens)
        $token = $user->createToken('auth:sanctum')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token // Uncomment this line if you return the token
        ], 200);
    }
}
