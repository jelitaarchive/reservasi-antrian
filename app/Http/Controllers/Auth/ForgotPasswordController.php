<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; 
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // STEP 1: Kirim OTP ke WhatsApp via Fonnte (Tetap sama)
    public function sendOtp(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|numeric'
        ]);

        $nomorWa = $request->whatsapp_number;

        // Cek apakah nomor terdaftar
        $userExists = User::where('whatsapp', $nomorWa)->exists();
        if (!$userExists) {
            return back()->withErrors(['whatsapp_number' => 'Nomor WhatsApp tidak terdaftar di sistem kami!']);
        }
        
        // Generate OTP
        $otpCode = rand(100000, 999999);

        // Simpan ke session
        session([
            'otp_code' => $otpCode,
            'otp_wa' => $nomorWa,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        $tokenFonnte = env('FONNTE_TOKEN');
        $isiPesan = "⚠️ *PENGAMANAN AKUN ANTRE.in*\n\nJangan bagikan kode ini kepada siapapun! Kode OTP Lupa Password Anda adalah:\n\n*{$otpCode}*\n\nKode ini hanya berlaku selama 5 menit. Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.";

        try {
            $response = Http::withHeaders([
                'Authorization' => $tokenFonnte
            ])->post('https://api.fonnte.com/send', [
                'target' => $nomorWa,
                'message' => $isiPesan,
                'countryCode' => '62',
            ]);

            $result = $response->json();

            if (isset($result['status']) && !$result['status']) {
                Log::error("Fonnte Gateway Error: " . ($result['reason'] ?? 'Unknown Error'));
                return back()->withErrors(['whatsapp_number' => 'Gagal mengirim pesan WhatsApp, sistem gateway bermasalah.']);
            }

        } catch (\Exception $e) {
            Log::error("Koneksi Fonnte Gagal: " . $e->getMessage());
            return back()->withErrors(['whatsapp_number' => 'Gagal menghubungi server WhatsApp, coba lagi nanti.']);
        }

        Log::info("OTP Lupa Password sukses dikirim via Fonnte ke nomor: {$nomorWa}");

        return redirect()->route('password.otp')->with('status', 'Kode OTP telah dikirim ke WhatsApp Anda!');
    }

    // STEP 2: Verifikasi OTP Sekaligus Ganti Password (Udah Modif Full Form)
    public function verifyOtp(Request $request)
    {
        // Masalah utama biasanya di sini: pastikan name di blade sesuai!
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|min:8|confirmed', 
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'password.min' => 'Password minimal harus 8 karakter!'
        ]);

        $otpInput = $request->otp;
        $sessionOtp = session('otp_code');
        $expiresAt = session('otp_expires_at');

        // Cek OTP Valid atau Enggak
        if (!$sessionOtp || now()->gt($expiresAt) || $otpInput != $sessionOtp) {
            Log::warning("Percobaan verifikasi OTP gagal atau kedaluwarsa untuk nomor: " . session('otp_wa'));
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa!'])->withInput();
        }

        // Ambil nomor WA dari session
        $nomorSession = session('otp_wa');
        if (!$nomorSession) {
            return redirect()->route('password.request')->withErrors(['whatsapp_number' => 'Sesi habis, silakan minta OTP ulang.']);
        }

        // Normalisasi string nomor wa biar pencarian ke DB makin akurat
        $nomorBersih = ltrim($nomorSession, '0'); 
        if (str_starts_with($nomorBersih, '62')) {
            $nomorBersih = substr($nomorBersih, 2); 
        }

        // Cari usernya di database
        $user = User::where('whatsapp', $nomorSession)
                    ->orWhere('whatsapp', '0' . $nomorBersih)
                    ->orWhere('whatsapp', '62' . $nomorBersih)
                    ->orWhere('whatsapp', 'LIKE', '%' . $nomorBersih)
                    ->first();

        // Jika user ketemu, langsung sikat update password di sini!
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            Log::info("User dengan ID {$user->id} BERHASIL update password baru.");

            // Bersihkan session biar ga bisa ditembak berkali-kali
            session()->forget(['otp_code', 'otp_wa', 'otp_expires_at']);

            // Redirect ke login dengan pesan sukses
            return redirect()->route('login')->with('status', 'Password baru berhasil disimpan! Silakan masuk.');
        }

        // Jika gagal nemu user di DB
        Log::error("Gagal ganti password. Nomor session ({$nomorSession}) ga klop sama DB.");
        return back()->withErrors(['otp' => 'Gagal mengidentifikasi akun Anda. Silakan coba lagi.']);
    }
}