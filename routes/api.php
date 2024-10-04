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
// ->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/create', [CapsuleController::class, 'create']);
    Route::post('/capsule', [CapsuleController::class, 'show']);
    Route::delete('/{id}', [CapsuleController::class, 'delete']);
});

Route::post('/register', [UserController::class, 'register']);
Route::get('/', [UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);
Route::delete('/sdfsdf/{id}', [UserController::class, 'destroy']);

// Route::apiResource('/', UserController::class);
