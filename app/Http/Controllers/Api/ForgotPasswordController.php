<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon tidak ditemukan'
            ], 404);
        }

        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['phone' => $request->phone],
            [
                'otp' => $otp,
                'expired_at' => now()->addMinutes(5),
            ]
        );

        // GANTI DENGAN TOKEN FONNTE KAMU
        $token = env('FONNTE_TOKEN');

        Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->phone,
            'message' =>
                "Kode OTP ANTRE.in Anda adalah: {$otp}\n\nBerlaku selama 5 menit.\nJangan berikan kode ini kepada siapa pun.",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil dikirim ke WhatsApp',
        ]);
    }

        public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required',
        ]);

        $otp = Otp::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->first();

        if (
            !$otp ||
            now()->greaterThan($otp->expired_at)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak valid atau sudah kadaluarsa'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP valid'
        ]);
    }

    public function resetPassword(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'otp' => 'required',
        'password' => 'required|min:6',
    ]);

    $otp = Otp::where('phone', $request->phone)
        ->where('otp', $request->otp)
        ->first();

    if (
        !$otp ||
        now()->greaterThan($otp->expired_at)
    ) {
        return response()->json([
            'success' => false,
            'message' => 'OTP tidak valid atau sudah kadaluarsa'
        ], 400);
    }

    $user = User::where('phone', $request->phone)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak ditemukan'
        ], 404);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    Otp::where('phone', $request->phone)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Password berhasil diubah'
    ]);
}
}