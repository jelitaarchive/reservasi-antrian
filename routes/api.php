<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAntreanController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\AntrianController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/antrian/store', [ApiAntreanController::class, 'storeFromApi']);
    
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post(
    '/forgot-password/send-otp',
    [ForgotPasswordController::class, 'sendOtp']
);

Route::post(
    '/forgot-password/verify-otp',
    [ForgotPasswordController::class, 'verifyOtp']
);

Route::post(
    '/forgot-password/reset',
    [ForgotPasswordController::class, 'resetPassword']
);

Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::put('/profile/{id}', [ProfileController::class, 'update']);

Route::post(
    '/profile/{id}/photo',
    [ProfileController::class, 'uploadPhoto']
);

Route::post('/pembayaran', [PembayaranController::class, 'store']);

Route::get('/test-pembayaran', function () {
    return response()->json([
        'status' => 'API Pembayaran Aktif'
    ]);
});

Route::post(
'/antrian',
[AntrianController::class,'store']
);


Route::get(
'/riwayat/{nim}',
[AntrianController::class,'riwayat']
);

// Endpoint Login Mahasiswa dari Flutter
Route::post('/login-mahasiswa', [ApiAuthController::class, 'login']);

// Endpoint Antrian (Wajib bawa Token Auth setelah login)
Route::middleware('auth:sanctum')->group(function () {
    // Mahasiswa ambil antrian dari Flutter
    Route::post('/tambah-antrian', [AntreanController::class, 'storeFromApi']);
    
    // Mahasiswa melihat riwayat antriannya sendiri di Flutter
    Route::get('/riwayat-antrian', [AntreanController::class, 'historyForApi']);
});

Route::prefix('antrian')->group(function () {
    
    // 1. Mahasiswa & Admin: Mengambil semua data antrian
    Route::get('/', [ApiAntreanController::class, 'index']);
    
    // 2. Mahasiswa & Admin: Mengambil detail satu antrian berdasarkan ID
    Route::get('/{id}', [ApiAntreanController::class, 'show']);
    
    // 3. Mahasiswa (Flutter) & Admin (Web): Membuat antrian baru
    Route::post('/store', [ApiAntreanController::class, 'store']);
    
    // 4. Admin: Mengubah/Update status atau data antrian
    Route::put('/update/{id}', [ApiAntreanController::class, 'update']);
    
    // 5. Admin: Menghapus antrian
    Route::delete('/delete/{id}', [ApiAntreanController::class, 'destroy']);
    
});