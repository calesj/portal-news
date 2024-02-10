<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeSectionSettingController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SocialCountController;
use Illuminate\Support\Facades\Route;

/** ADMIN ROUTES */
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

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin.auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    /** profile routes */
    Route::put('profile-password-update/{id}', [ProfileController::class, 'passwordUpdate'])
        ->name('profile-password.update');
    Route::resource('profile', ProfileController::class);

    /** Language Routes */
    Route::resource('language', LanguageController::class);

    /** Category Routes */
    Route::resource('category', CategoryController::class);

    /** News Routes */
    Route::get('fetch-news-category', [NewsController::class, 'fetchCategory'])->name('fetch-news-category');

    Route::get('news-copy/{id}', [NewsController::class, 'copyNews'])->name('news-copy');

    Route::get('toggle-news-status', [NewsController::class, 'toggleNewsStatus'])->name('toggle-news-status');
    Route::resource('news', NewsController::class);

    /** Home Section Setting Routes */
    Route::get('home-section-setting', [HomeSectionSettingController::class, 'index'])
        ->name('home-section-setting.index');

    Route::put('home-section-setting', [HomeSectionSettingController::class, 'update'])
        ->name('home-section-setting.update');

    /** Social Count Routes */
    Route::resource('social-count', SocialCountController::class);
});



