<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
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

    // Admin Routes - Requires authentication AND admin role
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            // Dashboard
            Route::get('/dashboard', 'showDashboard')->name('dashboard');
        });
    });

    // Staff Routes - Requires authentication AND staff role
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::controller(StaffController::class)->group(function () {
            // Dashboard
            Route::get('/dashboard', 'showDashboard')->name('dashboard');
        });
    });

    // Student Routes - Requires authentication AND student role
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::controller(StudentController::class)->group(function () {
            // Dashboard
            Route::get('/dashboard', 'showDashboard')->name('dashboard');
        });
    });
});

// Fallback route
Route::fallback(function () {
    return redirect()->route('login');
});