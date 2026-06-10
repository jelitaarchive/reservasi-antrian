<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController; // Controller OTP baru kita
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // ==========================================
    // ALUR LUPA PASSWORD VIA WHATSAPP (UBAHAN BARU)
    // ==========================================
    
    // 1. Halaman Input No. WA & Aksi Kirim OTP
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.send_otp');

    // 2. Halaman Input OTP & Aksi Verifikasi
    Route::get('verify-otp', function () {
        return view('auth.verify-otp');
    })->name('password.otp');

    Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
        ->name('password.verify_otp');

    // 3. Halaman Buat Password Baru & Aksi Update Database
    Route::get('reset-password', function () {
        return view('auth.reset-password');
    })->name('password.reset');

    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.store');
        
    // ==========================================
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Mengubah route password.update bawaan agar tidak bentrok (opsional tapi aman)
    Route::put('password-change', [PasswordController::class, 'update'])->name('password.change_profile');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});