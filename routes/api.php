<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\AntrianController;


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

