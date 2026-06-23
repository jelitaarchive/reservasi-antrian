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
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AdminMahasiswaController;
use App\Http\Controllers\AdminVerifikasiController;
use App\Http\Controllers\AdminMonitoringController;

// Halaman Utama / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ========================================================
// GRUP AKSES KHUSUS ADMIN (Prefix: /admin)
// ========================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // 1. Dashboard Utama Admin -> Jalur: /admin/dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // 2. Kelola Antrian -> Jalur: /admin/kelola-antrian
    Route::get('/kelola-antrian', [AdminDashboardController::class, 'kelolaAntrian'])->name('admin.kelola.antrian');
    
    // 3. Kelola Layanan -> Jalur: /admin/kelola-layanan
    Route::get('/kelola-layanan', [AdminDashboardController::class, 'kelolaLayanan'])->name('admin.kelola.layanan');
    
    // 4. Edit Profil Khusus Admin -> Jalur: /admin/profile
    Route::get('/profile', function () {
        return view('admin.profil-admin'); 
    })->name('admin.profile.edit');

    // 5. Aksi Antrian (Ubah Status & Hapus) -> Jalur: /admin/antrian/...
    Route::patch('/antrian/{id}/status/{status}', [AdminDashboardController::class, 'updateStatus'])->name('admin.antrian.update-status');
    Route::delete('/antrian/{id}/delete', [AdminDashboardController::class, 'destroy'])->name('admin.antrian.destroy');

    // 6. Kelola Mahasiswa
    Route::get('/kelola-mahasiswa', [AdminMahasiswaController::class, 'index'])->name('admin.kelola.mahasiswa');
    Route::delete('/kelola-mahasiswa/{nim}/delete', [AdminMahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');

    // 7. Verifikasi Berkas
    Route::get('/verifikasi-berkas', [AdminVerifikasiController::class, 'index'])->name('admin.verifikasi.berkas');
    Route::patch('/verifikasi-berkas/{id}/update-status', [AdminVerifikasiController::class, 'updateStatus'])->name('admin.verifikasi.update');

    // 8. Monitoring Antrian
    Route::get('/monitoring-antrian', [AdminMonitoringController::class, 'index'])->name('admin.monitoring');
    Route::post('/monitoring-antrian/panggil', [AdminMonitoringController::class, 'panggilBerikutnya'])->name('admin.monitoring.panggil');
    
});

Route::get('/admin/kelola-layanan', [AdminLayananController::class, 'index'])->name('admin.kelola-layanan');
Route::post('/admin/kelola-layanan', [AdminLayananController::class, 'store'])->name('admin.layanan-store');

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