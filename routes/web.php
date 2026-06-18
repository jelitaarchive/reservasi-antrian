<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\QueueHistoryController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\AdminDashboardController;

// Halaman Utama / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ========================================================
// GRUP AKSES KHUSUS ADMIN (Hanya Bisa Diakses Jika Role = admin)
// ========================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Utama Admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Edit Profil Khusus Admin (resources/views/admin/profil.blade.php)
    Route::get('/admin/profile', function () {
        return view('admin.profil-admin'); 
    })->name('admin.profile.edit');
});

// ========================================================
// GRUP AKSES KHUSUS SISTEM (Hanya Bisa Diakses Jika Role = sistem)
// ========================================================
Route::middleware(['auth', 'role:sistem'])->group(function () {
    Route::get('/sistem/dashboard', function () {
        return view('sistem.dashboard');
    });
});

// ========================================================
// GRUP AKSES UMUM & MAHASISWA (Wajib Login)
// ========================================================
Route::middleware(['auth'])->group(function () {
    
    // Pintu Utama Setelah Login (Dicek dinamis oleh DashboardController untuk membagi role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Alur Beranda Layanan Mahasiswa
    Route::get('/pembayaran', function () {
        return view('pembayaran');
    })->name('pembayaran');

    // Layanan Administrasi Akademik Mahasiswa
    Route::get('/administrasi', [AdministrasiController::class, 'index'])->name('administrasi');

    // Fitur Tambah Antrian Mahasiswa
    Route::get('/tambah-antrian', function () {
        return view('tambah-antrian'); 
    })->name('tambah.antrian');

    // Fitur Monitoring Antrian 
    Route::get('/monitoring-antrian', [AntreanController::class, 'monitoring'])->name('monitoring.antrian');

    // Fitur Riwayat Antrian
    Route::get('/riwayat-antrian', [QueueHistoryController::class, 'index'])->name('riwayat.antrian');

    // Manajemen Akun / Profil Saya (Khusus Mahasiswa -> resources/views/profil.blade.php)
    Route::get('/profile', function () {
        return view('profil'); 
    })->name('profile.edit');

    // Proses Update dan Delete Profil (Dipakai Bersama lewat Request Handler)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Form Submission Antrian
    Route::post('/tambah-antrian', [AntreanController::class, 'store'])->name('tambah.antrian.store');
    Route::post('/antrian/store', [AntreanController::class, 'store'])->name('antrian.store');
    
    // Fitur Lupa Password & Verifikasi OTP via WhatsApp / SMS
    // 1. Halaman minta link / input email reset
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // 2. Tampilkan halaman form input OTP
    Route::get('/forgot-password/otp', [PasswordResetLinkController::class, 'showOtpForm'])->name('password.otp.form');

    // 3. Proses verifikasi OTP saat tombol "Verifikasi Kode" diklik
    Route::post('/forgot-password/verify-otp', [PasswordResetLinkController::class, 'resetPasswordWithOtp'])->name('password.verify_otp');
});

// ========================================================
// RUTE DI LUAR AUTHENTICATION (RESET PASSWORD LAWAN OTP)
// ========================================================
Route::get('/reset-password', function() {
    return view('auth.reset-password');
})->name('password.reset');

// Proses simpan password baru
Route::post('/reset-password/save', [ForgotPasswordController::class, 'resetPassword'])->name('password.update_custom');

// Load file routing bawaan Laravel Breeze / Jetstream (Login, Register, dll)
require __DIR__.'/auth.php';