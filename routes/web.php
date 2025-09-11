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
             Route::get('/dashboard', [StaffController::class, 'showDashboard'])->name('dashboard');
            Route::get('/profile', [StaffController::class, 'showProfile'])->name('profile');
            Route::get('/profile/edit', [StaffController::class, 'editProfile'])->name('profile.edit');
            Route::post('/profile/update', [StaffController::class, 'updateProfile'])->name('profile.update');
            
            // Document Management Routes
            Route::get('/documents', [StaffController::class, 'showDocuments'])->name('documents');
            Route::post('/documents', [StaffController::class, 'storeDocument'])->name('documents.store');
            Route::get('/documents/{document}/edit', [StaffController::class, 'editDocument'])->name('documents.edit');
            Route::put('/documents/{document}', [StaffController::class, 'updateDocument'])->name('documents.update');
            Route::delete('/documents/{document}', [StaffController::class, 'destroyDocument'])->name('documents.destroy');
            Route::get('/documents/{document}/download', [StaffController::class, 'downloadDocument'])->name('documents.download');
            
            // Other existing routes...
            Route::get('/announcements', [StaffController::class, 'showAnnouncement'])->name('announcements');
            Route::get('/feedbacks', [StaffController::class, 'showFeedbacks'])->name('feedbacks');
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