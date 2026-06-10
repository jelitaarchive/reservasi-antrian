<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\QueueHistoryController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdministrasiController;


// Halaman Utama / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// GRUP AKSES BERDASARKAN ROLE (MIDDLEWARE)
// ==========================================

// MAHASISWA
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () {
        return view('dashboard');
    });
});

// ADMINISTRASI
Route::middleware(['auth', 'role:administrasi'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

// SISTEM
Route::middleware(['auth', 'role:sistem'])->group(function () {
    Route::get('/sistem/dashboard', function () {
        return view('sistem.dashboard');
    });
});


// ==========================================
// GRUP AKSES UMUM (YANG PENTING SUDAH LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Halaman Alur Beranda Layanan
    Route::get('/pembayaran', function () {
        return view('pembayaran');
    })->name('pembayaran');

    Route::get('/administrasi', function () {
        return view('administrasi');
    })->name('administrasi');

    // Fitur Tambah Antrian
    Route::get('/tambah-antrian', function () {
        return view('tambah-antrian'); 
    })->name('tambah.antrian');

    // Fitur Monitoring Antrian (Halaman Baru)
    Route::get('/monitoring', function () {
        return view('monitoring');
    })->name('monitoring.antrian');

    // Fitur Riwayat Antrian (Disinkronkan ke name: riwayat.antrian)
    Route::get('/riwayat-antrian', [QueueHistoryController::class, 'index'])->name('riwayat.antrian');

    // Manajemen Akun / Profil Saya
    Route::get('/profile', function () {
        return view('profil'); // Mengarah ke resources/views/profil.blade.php
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/antrian/store', [AntreanController::class, 'store'])->name('antrian.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/administrasi', [AdministrasiController::class, 'index'])->name('administrasi');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/forgot-password/reset-with-otp', [PasswordResetLinkController::class, 'resetPasswordWithOtp'])->name('password.otp.reset');

});

Route::get('/test-wa', function () {
    // 1. Ambil token dari .env
    $token = env('FONNTE_TOKEN'); 
    
    // 2. GANTI dengan nomor WhatsApp HP kamu sendiri buat test (awali dengan 62 atau 08)
    $nomorHP = '628xxxxxxxxxx'; 
    
    $pesan = "🔥 *TESTING SUCCESS!* 🔥\n\nHalo Bubb, kalau chat ini masuk, berarti API WhatsApp kamu di Laravel udah sukses terkoneksi 100%! Siap lanjut ngoding fitur reminder antrian. 😎🚀";

    // 3. Tembak API Fonnte
    try {
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomorHP,
            'message' => $pesan,
            'countryCode' => '62',
        ]);

        // Tampilkan hasil response di browser buat ngecek statusnya
        return response()->json([
            'info' => 'Request dikirim, cek hasilnya dibawah:',
            'response_dari_fonnte' => $response->json()
        ]);

    } catch (\Exception $e) {
        return 'Waduh error bubb: ' . $e->getMessage();
    }
});

// Load file routing bawaan Laravel Breeze / Jetstream (Login, Register, dll)
require __DIR__.'/auth.php';