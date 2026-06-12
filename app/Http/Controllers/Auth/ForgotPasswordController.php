<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // Wajib import untuk nembak API Fonnte
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // STEP 1: Kirim OTP ke WhatsApp rill via Fonnte
    public function sendOtp(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|numeric'
        ]);

        $nomorWa = $request->whatsapp_number;

        // Tambahan Keamanan: Cek dulu nomornya ada gak di tabel users
        $userExists = User::where('whatsapp', $nomorWa)->exists();
        if (!$userExists) {
            return back()->withErrors(['whatsapp_number' => 'Nomor WhatsApp tidak terdaftar di sistem kami!']);
        }
        
        // Generate 6 digit angka random
        $otpCode = rand(100000, 999999);

        // Simpan OTP ke session dengan masa berlaku 5 menit
        session([
            'otp_code' => $otpCode,
            'otp_wa' => $nomorWa,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // === INTEGRASI API FONNTE WHATSAPP ===
        $tokenFonnte = env('FONNTE_TOKEN');
        $isiPesan = "⚠️ *PENGAMANAN AKUN ANTRE.in*\n\nJangan bagikan kode ini kepada siapapun! Kode OTP Lupa Password Anda adalah:\n\n*{$otpCode}*\n\nKode ini hanya berlaku selama 5 menit. Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.";

        try {
            // Tembak server Fonnte
            $response = Http::withHeaders([
                'Authorization' => $tokenFonnte
            ])->post('https://api.fonnte.com/send', [
                'target' => $nomorWa,
                'message' => $isiPesan,
                'countryCode' => '62',
            ]);

            $result = $response->json();

            // Cek kalau Fonnte ngasih respon gagal (misal device off/token salah)
            if (isset($result['status']) && !$result['status']) {
                Log::error("Fonnte Gateway Error: " . ($result['reason'] ?? 'Unknown Error'));
                return back()->withErrors(['whatsapp_number' => 'Gagal mengirim pesan WhatsApp, sistem gateway bermasalah.']);
            }

        } catch (\Exception $e) {
            // Mencegah aplikasi crash kalau internet server down
            Log::error("Koneksi Fonnte Gagal: " . $e->getMessage());
            return back()->withErrors(['whatsapp_number' => 'Gagal menghubungi server WhatsApp, coba lagi nanti.']);
        }

        // Catat log sekadarnya tanpa membocorkan kode OTP asli demi keamanan
        Log::info("OTP Lupa Password sukses dikirim via Fonnte ke nomor: {$nomorWa}");

        // Alihkan ke form pengisian kode OTP (sesuai route figma-mu `verify-otp.blade.php`)
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
            
            // Jika gagal: Kembalikan dengan error
            return redirect()->route('password.otp')->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa!']);
        }

        // Jika benar, tandai session bahwa OTP sudah terverifikasi
        session(['otp_verified' => true]);

        Log::info("Nomor " . session('otp_wa') . " berhasil melakukan verifikasi OTP.");

        // Redirect ke halaman buat password baru
        return redirect()->route('password.reset');
    }

    // STEP 3: Reset Password (VERSI FIX - ANTI GAGAL)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed', 
        ]);

        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['whatsapp_number' => 'Akses ilegal. Selesaikan verifikasi OTP dahulu.']);
        }

        // 1. Ambil nomor WA dari session
        $nomorSession = session('otp_wa');

        // Normalisasi nomor: ambil angka belakangnya aja buat jaga-jaga format 08 atau 62
        $nomorBersih = ltrim($nomorSession, '0'); // Hapus angka 0 di depan jika ada
        if (str_starts_with($nomorBersih, '62')) {
            $nomorBersih = substr($nomorBersih, 2); // Hapus angka 62 di depan jika ada
        }

        // 2. Cari user di DB dengan pencarian super fleksibel (Mencakup 08xxx, 62xxx, atau langsung xxx)
        $user = User::where('whatsapp', $nomorSession)
                    ->orWhere('whatsapp', '0' . $nomorBersih)
                    ->orWhere('whatsapp', '62' . $nomorBersih)
                    ->orWhere('whatsapp', 'LIKE', '%' . $nomorBersih)
                    ->first();

        // 3. Eksekusi simpan jika user ketemu
        if ($user) {
            // Update password baru di database
            $user->password = Hash::make($request->password);
            $user->save();

            Log::info("User dengan ID {$user->id} dan nomor {$user->whatsapp} BERHASIL ganti password baru.");

            // Hapus semua data session OTP biar bersih
            session()->forget(['otp_code', 'otp_wa', 'otp_expires_at', 'otp_verified']);

            // Sukses! Lempar ke halaman login utama
            return redirect()->route('login')->with('status', 'Password baru berhasil disimpan! Silakan masuk kembali.');
        }

        // JIKA GAGAL: Berarti nomor beneran gak ada di DB, kita kasih tau error-nya di layar biar kelihatan
        Log::error("Gagal mereset password. Nomor dari session ({$nomorSession}) tidak cocok dengan data apapun di DB.");
        
        return redirect()->route('password.request')->withErrors([
            'whatsapp_number' => 'Sistem gagal mengidentifikasi akun Anda. Pastikan nomor WA di profil sama dengan yang diinput!'
        ]);
    }
}