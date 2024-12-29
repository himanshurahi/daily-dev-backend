<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    // Register route
    Route::post('register', [AuthController::class, 'register']);

    // Login route
    Route::post('login', [AuthController::class, 'login']);

    //Logout
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    //Update Profile
    Route::put('update', [\App\Http\Controllers\UserController::class, 'update']);
});

//Post
Route::apiResource('posts', \App\Http\Controllers\PostController::class)->middleware('auth:sanctum');
