<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    /**
     * Fungsi Inti untuk mengirim pesan WhatsApp
     *
     * @param string $target (Nomor HP tujuan, contoh: 08123456789 atau 628123456789)
     * @param string $message (Isi pesan teks yang ingin dikirim)
     * @return array
     */
    public static function sendMessage($target, $message)
    {
        // 1. Ambil token dari file .env
        $token = env('FONNTE_TOKEN');

        // 2. Tembak API Fonnte menggunakan HTTP POST
        try {
            $response = Http::withHeaders([
                'Authorization' => $token, // Autentikasi token Fonnte
            ])->post('https://api.fonnte.com/send', [
                'target'      => $target,
                'message'     => $message,
                'countryCode' => '62', // Memastikan nomor lokal Indonesia otomatis ter-handle
            ]);

            // Kembalikan response berupa array JSON dari Fonnte
            return $response->json();

        } catch (\Exception $e) {
            // Jika koneksi internet/server down, tangkap error-nya
            return [
                'status'  => false,
                'message' => 'Gagal terhubung ke API Gateway: ' . $e->getMessage()
            ];
        }
    }
}