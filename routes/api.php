<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CapsuleController;

Route::post('/user', [Controller::class, 'register']); 

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/showName/{id}', [UserController::class, 'usernameView']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',[UserController::class, 'logout']);
});

Route::get('/view/{received_capsule}', [CapsuleController::class, 'view']);
Route::apiResource('capsules', CapsuleController::class);
Route::post('/send', [CapsuleController::class, 'send']);

Route::get('/', [UserController::class, 'index']);
Route::delete('/{id}', [UserController::class, 'destroy']);
