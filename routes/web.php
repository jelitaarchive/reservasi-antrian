<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueHistoryController;

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
});

// Load file routing bawaan Laravel Breeze / Jetstream (Login, Register, dll)
require __DIR__.'/auth.php';