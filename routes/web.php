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
            Route::get('/profile', 'showProfile')->name('profile');
            Route::get('/profile/edit', 'editProfile')->name('profile.edit');
            Route::post('/profile/update', 'updateProfile')->name('profile.update');
            
            // Document Management Routes
            Route::get('/documents', 'showDocuments')->name('documents');
            Route::post('/documents', 'storeDocument')->name('documents.store');
            Route::get('/documents/{document}/edit', 'editDocument')->name('documents.edit');
            Route::put('/documents/{document}', 'updateDocument')->name('documents.update');
            Route::delete('/documents/{document}', 'destroyDocument')->name('documents.destroy');
            Route::get('/documents/{document}/download', 'downloadDocument')->name('documents.download');
            
            // Announcement routes
            Route::get('/announcements', 'showAnnouncements')->name('announcements');
            Route::get('/announcements/create', 'createAnnouncement')->name('announcements.create');
            Route::post('/announcements', 'storeAnnouncement')->name('announcements.store');
            Route::get('/announcements/{announcement}/edit', 'editAnnouncement')->name('announcements.edit');
            Route::put('/announcements/{announcement}', 'updateAnnouncement')->name('announcements.update');
            Route::delete('/announcements/{announcement}', 'destroyAnnouncement')->name('announcements.destroy');
            Route::get('/announcements/{announcement}/download', 'downloadAnnouncementAttachment')->name('announcements.download');

            // Feedback routes
            Route::get('/feedbacks', 'showFeedbacks')->name('feedbacks');
            Route::get('/feedbacks/{feedback}/details', 'getFeedbackDetails')->name('feedbacks.details');
            Route::post('/feedbacks/{feedback}/assign', 'assignFeedback')->name('feedbacks.assign');
            Route::post('/feedbacks/{feedback}/reply', 'replyFeedback')->name('feedbacks.reply');
            Route::patch('/feedbacks/{feedback}/status', 'updateFeedbackStatus')->name('feedbacks.status');
            Route::get('/feedbacks/{feedback}/download', 'downloadFeedbackAttachment')->name('feedbacks.download');
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