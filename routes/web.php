<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueHistoryController;


Route::get('/', function () {
    return view('welcome');
});

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

// Dashboard Utama
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->middleware(['auth'])->name('pembayaran');

Route::get('/administrasi', function () {
    return view('administrasi');
})->middleware(['auth'])->name('administrasi');

// Tambah Antrian
Route::get('/tambah-antrian', function () {
    return view('tambah-antrian'); 
})->middleware(['auth'])->name('tambah.antrian');

// PERBAIKAN: Rute Akun Saya / Profil
Route::middleware('auth')->group(function () {
    /** @slots profile */
    Route::get('/profile', function () {
        return view('profil'); // Mengarah ke resources/views/profil.blade.php
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Jalur akses untuk melihat halaman Riwayat Antrian
Route::get('/riwayat-antrian', [QueueHistoryController::class, 'index'])->name('antrean.riwayat');

});

require __DIR__.'/auth.php';