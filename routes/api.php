<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CapsuleController;

Route::post('/user', function (Request $request) {
    $user = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
        'age' => 'required'
    ]);

    $user = User::create([
        'name' => $user['name'],
        'email' => $user['email'],
        'password' => Hash::make($user['password']),
        'age' => $user['age']
    ]);
    return response()->json($user, 201);
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',[UserController::class, 'logout']);
});

Route::apiResource('capsules', CapsuleController::class);
Route::post('capsules/send', [CapsuleController::class, 'send']);
Route::get('/', [UserController::class, 'index']);
Route::delete('/f/{id}', [UserController::class, 'destroy']);
