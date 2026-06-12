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
    // 1. Halaman minta link / input email reset (Halaman pertama)
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // 2. Tampilkan halaman form input OTP figma kamu ini
    Route::get('/forgot-password/otp', [PasswordResetLinkController::class, 'showOtpForm'])->name('password.otp.form');

    // 3. Proses verifikasi OTP saat tombol "Verifikasi Kode" diklik
    Route::post('/forgot-password/verify-otp', [PasswordResetLinkController::class, 'resetPasswordWithOtp'])->name('password.verify_otp');

});

Route::get('/reset-password', function() {
    return view('auth.reset-password');
})->name('password.reset');

// Proses simpan password barunya
Route::post('/reset-password/save', [ForgotPasswordController::class, 'resetPassword'])->name('password.update_custom');

// // Route::get('/test-whatsapp-api', function() {
    // Tentukan nomor tujuan (Gunakan nomor HP kamu sendiri untuk uji coba)
    //$nomorTujuan = '6281234567890'; // Sesuaikan nomor HP-mu!
    
    // Format teks menggunakan Markdown WhatsApp agar terlihat profesional
    //$isiPesan = "⭐ *SISTEM NOTIFIKASI ANTRE.in* ⭐\n\nHalo Bubb!\n\nJika kamu menerima pesan ini, selamat! Integrasi *WhatsApp API Gateway (Fonnte)* pada project Laravel kamu telah *BERHASIL* terpasang 100%.\n\nReady untuk lanjut ke fitur OTP dan Antrian! 🚀🔥";

    // Panggil fungsi static yang sudah kita buat tadi
    //$hasil = WhatsAppController::sendMessage($nomorTujuan, $isiPesan);

    // Tampilkan hasilnya di browser
    //return response()->json([
        //'keterangan' => 'Status pengiriman dari server lokal:',
        //'response_fonnte' => $hasil
    //]);
//});


// Load file routing bawaan Laravel Breeze / Jetstream (Login, Register, dll)
require __DIR__.'/auth.php';