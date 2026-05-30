<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// MAHASISWA
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {

    Route::get('/mahasiswa/dashboard', function () {
        return view('dashboard'); // Menampilkan file Figma jika URL ini diakses
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

// Dashboard Utama (Desain Figma)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    /** @slots profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';