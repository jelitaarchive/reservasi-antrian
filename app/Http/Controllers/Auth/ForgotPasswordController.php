<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import facades Logging
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User sudah ada

class ForgotPasswordController extends Controller
{
    // STEP 1: Kirim OTP ke WhatsApp
    public function sendOtp(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|numeric'
        ]);

        $nomorWa = $request->whatsapp_number;
        
        // Generate 6 digit angka random
        $otpCode = rand(100000, 999999);

        // Simpan OTP ke session (atau database) dengan masa berlaku 5 menit
        session([
            'otp_code' => $otpCode,
            'otp_wa' => $nomorWa,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // --- CONTOH LOGGING ---
        // Mencatat aktivitas ke storage/logs/laravel.log untuk memantau sistem
        Log::info("OTP Lupa Password berhasil dibuat untuk nomor: {$nomorWa}. Kode OTP: {$otpCode}");

        // Simulasi mengirim ke WhatsApp API (bisa diganti dengan CURL API WA nanti)
        // Di sini kita anggap sukses terkirim dan infokan ke user
        //  GANTI DENGAN KODE INI:
        return redirect()->route('password.otp')->with('status', 'Kode OTP telah dikirim ke WhatsApp Anda!');
    }

    // STEP 2: Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $otpInput = $request->otp;
        $sessionOtp = session('otp_code');
        $expiresAt = session('otp_expires_at');

        // Validasi kecocokan dan kedaluwarsa
        if (!$sessionOtp || now()->gt($expiresAt) || $otpInput != $sessionOtp) {
            
            Log::warning("Percobaan verifikasi OTP gagal atau kedaluwarsa untuk nomor: " . session('otp_wa'));
            
            // --- JIKA GAGAL: Kembalikan ke halaman OTP dengan pesan error ---
            return redirect()->route('password.otp')->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa!']);
        }

        // Jika benar, tandai session bahwa OTP sudah terverifikasi
        session(['otp_verified' => true]);

        Log::info("Nomor " . session('otp_wa') . " berhasil melakukan verifikasi OTP.");

        // --- 🚀 JIKA SUKSES: Redirect ke halaman Buat Password Baru ---
        return redirect()->route('password.reset');
    }

    // STEP 3: Reset Password & Redirect Kembali ke Login
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed', // 'confirmed' memastikan password_confirmation cocok
        ]);

        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['whatsapp_number' => 'Akses ilegal. Selesaikan verifikasi OTP dahulu.']);
        }

        // Cari user berdasarkan nomor WhatsApp yang disimpan di session tadi
        $user = User::where('whatsapp', session('otp_wa'))->first();

        if ($user) {
            // Update password baru di database
            $user->password = Hash::make($request->password);
            $user->save();

            // Log aktivitas krusial (Perubahan Password)
            Log::info("User dengan nomor {$user->whatsapp} berhasil mengubah password-nya.");

            // Hapus semua data session OTP setelah selesai
            session()->forget(['otp_code', 'otp_wa', 'otp_expires_at', 'otp_verified']);

            // --- 🚀 JIKA SUKSES: Redirect ke halaman Login Utama bawaan Laravel ---
            return redirect()->route('login')->with('status', 'Password baru berhasil disimpan! Silakan masuk kembali.');
        }

        Log::error("Gagal mereset password. Nomor " . session('otp_wa') . " tidak ditemukan di database.");
        return redirect()->route('password.request')->withErrors(['whatsapp_number' => 'Nomor WhatsApp tidak terdaftar di database kami.']);
    }
}