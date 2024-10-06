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
            'name' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'age' => 'nullable|integer'
        ]);
        
        $user = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
            'age' => $user['age']
        ]);

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        
        return response()->json([
            'data' => $user,
            'token' => $token
        ], 201);
    }

    public function index() {
        $users = User::get(); // Retrieve all users
        return UserResource::collection($users);
    }

    public function destroy($id) {
        $user = User::find($id);
        // return User::delete();
        $user->delete(); // Delete the specific user

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

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
        $token = $user->createToken('Personal Access Token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request) {
        $user = User::where('id', $request->user()->id)->first();

        if($user) {
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logged out Successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
}
