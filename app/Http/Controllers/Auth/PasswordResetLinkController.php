<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    // 1. KIRIM OTP KE WHATSAPP (Berdasarkan Email)
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        if (!$user->whatsapp) {
            return back()->withErrors(['email' => 'Nomor WhatsApp belum terdaftar di akun ini.']);
        }

        // Bikin OTP 6 digit angka
        $otpCode = rand(100000, 999999);

        // Simpan ke tabel token reset
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $otpCode, 
                'created_at' => now()
            ]
        );

        // Tembak API Fonnte
        $tokenWA = env('FONNTE_TOKEN'); 
        $pesan = "⚠️ *PENGAMANAN AKUN ANTRE.in*\n\nKode OTP reset password Anda adalah:\n\n*{$otpCode}*\n\nJangan bagikan kode ini kepada siapapun!";

        try {
            Http::withHeaders(['Authorization' => $tokenWA])->post('https://api.fonnte.com/send', [
                'target' => $user->whatsapp,
                'message' => $pesan,
                'countryCode' => '62',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim WA, coba lagi nanti.']);
        }

        // Lempar ke halaman input OTP sambil simpan email di session agar tidak perlu ngetik email lagi
        session(['reset_email' => $user->email]);

        return redirect()->route('password.otp')->with('status', 'Kode OTP telah dikirim ke WhatsApp Anda!');
    }

    // 2. TAMPILKAN HALAMAN INPUT OTP & PASSWORD BARU
    public function showOtpForm(): View
    {
        // Pastikan session email masih ada, kalau tidak ada balikkan ke halaman input email
        if (!session('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi habis, silakan masukkan email kembali.']);
        }

        return view('auth.verify-otp'); 
    }

    // 3. PROSES VERIFIKASI OTP & UPDATE PASSWORD (FIXED - ANTI GAGAL)
    public function resetPasswordWithOtp(Request $request): RedirectResponse
    {
        // Ambil email dari session secara otomatis
        $emailSession = session('reset_email');

        if (!$emailSession) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi Anda telah berakhir, silakan request OTP kembali.']);
        }

        // Validasi inputan form dari screenshot
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'password.min' => 'Password minimal harus 8 karakter!'
        ]);

        // Cek apakah OTP cocok dengan email di tabel password_reset_tokens
        $resetData = DB::table('password_reset_tokens')
            ->where('email', $emailSession)
            ->where('token', $request->otp)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa!'])->withInput();
        }

        // Jika cocok, update password user di tabel users
        $user = User::where('email', $emailSession)->first();
        
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Hapus token dan session biar bersih & aman
            DB::table('password_reset_tokens')->where('email', $emailSession)->delete();
            session()->forget('reset_email');

            return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login dengan password baru.');
        }

        return redirect()->route('password.request')->withErrors(['email' => 'Gagal memproses perubahan password.']);
    }
}