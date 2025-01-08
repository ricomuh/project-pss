<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->as('api.auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
    // Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    //     return $request->user();
    // })->name('user');

    Route::middleware(['auth:sanctum'])->as('user')->group(function () {
        Route::get('/user', [UserController::class, 'show'])->name('show');
        Route::put('/user', [UserController::class, 'update'])->name('update');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);
});
