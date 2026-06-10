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

    // 1. KIRIM OTP KE WHATSAPP
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

        // Simpan ke tabel token reset (kita simpan mentah/plain dulu biar gampang dicocokkan lewat input)
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

        // Lempar ke halaman input OTP sambil bawa data email via session
        return redirect()->route('verify_otp')->with(['status' => 'Kode OTP telah dikirim ke WhatsApp!', 'reset_email' => $user->email]);
    }

    // 2. TAMPILKAN HALAMAN INPUT OTP & PASSWORD BARU
    public function showOtpForm(): View
    {
        return view('auth.verify-otp');
    }

    // 3. PROSES VERIFIKASI OTP & UPDATE PASSWORD
    public function resetPasswordWithOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cek apakah OTP cocok dengan email di tabel password_reset_tokens
        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa!'])->withInput();
        }

        // Jika cocok, update password user di tabel users
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token biar gak bisa dipake lagi
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login dengan password baru.');
    }
}