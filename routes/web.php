<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dash');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
