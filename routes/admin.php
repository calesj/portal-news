<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', [AdminAuthController::class, 'login'])->name('login.get');
    Route::post('login', [AdminAuthController::class, 'handleLogin'])->name('login.post');

    /** Reset Password */
    Route::get('forgot-password', [AdminAuthController::class, 'forgotPassword'])
        ->name('forgot-password');

    /** Send an email with token */
    Route::post('forgot-password', [AdminAuthController::class, 'sendResetLink'])
        ->name('forgot-password.send');

    /** Render reset password view */
    Route::get('forgot-password/{token}', [AdminAuthController::class, 'resetPassword'])
        ->name('reset-password');

    /** Reset password finally */
    Route::post('reset-password-post', [AdminAuthController::class, 'handleResetPassword'])
        ->name('reset-password.send');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});



