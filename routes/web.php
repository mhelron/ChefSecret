<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;

use App\Http\Middleware\Auth;
use App\Http\Middleware\VerifyRoles;

// Login Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.index');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'sendResetLink'])->name('password.reset.send');
Route::get('/new-password', [PasswordResetController::class, 'showNewPasswordForm'])->name('password.new');
Route::post('/new-password', [PasswordResetController::class, 'confirmReset'])->name('password.reset.confirm');

// Email Verification Routes
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
    ->name('verification.notice');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
    ->name('verification.send');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify');

// Middleware
Route::middleware([Auth::class])->group(function () {
    // Dashboard Route
    Route::group(['middleware' => VerifyRoles::class . ':Super Admin,Admin,Manager,Staff'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });
}); 
