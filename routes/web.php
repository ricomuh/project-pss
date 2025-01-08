<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dash');
})
    ->middleware(['auth'])
    ->name('dashboard');
Route::middleware('auth')->as('admin.')->group(function () {

    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::delete('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');
});

require __DIR__ . '/auth.php';
