<?php

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes Group (only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {

        // Login Routes
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');

        Route::get('/forgot-password', 'showForgotPassword')->name('password.request');


    });
});

// Authentication Required Routes
Route::middleware(['auth'])->group(function () {
    // Auth Controller Routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');

    });

    // Admin Routes - Requires authentication AND email verification
    Route::middleware(['verified'])->prefix('admin')->name('admin.')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            // Dashboard
            Route::get('/dashboard', 'showDashboard')->name('dashboard');


        });

  
    });
});

// Fallback route
Route::fallback(function () {
    return redirect()->route('login');
});