<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http; // FIX: Diubah dari Https ke Http bawaan Laravel
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function store(Request $request)
    {
        // Tetap membuat antrian di database mobile seperti biasa
        $antrian = Antrian::create([
            'nama'=>$request->nama,
            'nim'=>$request->nim,
            'email'=>$request->email,
            'whatsapp'=>$request->whatsapp,
            'jenis_layanan'=>$request->jenis_layanan,
            'kategori_layanan'=>$request->kategori_layanan,
            'metode_pembayaran'=>$request->metode_pembayaran,
            'waktu_layanan'=>$request->waktu_layanan,
            'nomor_antrian'=>$request->nomor_antrian,
            'tanggal_antrian'=>now(),
            'status'=>$request->status,
            'bukti_transfer'=>$request->bukti_transfer
        ]);

        // DITAMBAHKAN: Lempar data ke Web Admin secara otomatis via REST API
        try {
            // Sesuaikan URL dan Port ini dengan server Web Admin Laravel kamu yang sedang running
            $webAdminUrl = 'http://127.0.0.1:8000/api/tambah-antrian-mobile'; 

            Http::timeout(5)->post($webAdminUrl, [
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama'          => $antrian->nama,
                'nim'           => $antrian->nim,
                'jenis_layanan' => $antrian->jenis_layanan,
            ]);
        } catch (\Exception $e) {
            // Jika web admin mati/gagal diakses, backend mobile tidak akan crash dan tetap return sukses ke Flutter
            \Log::error("Gagal sinkronisasi antrean baru ke Web Admin: " . $e->getMessage());
        }

        return response()->json([
            'message'=>'berhasil',
            'data'=>$antrian
        ]);
    }

    public function riwayat($nim)
    {
        $data = Antrian::where('nim', $nim)
            ->latest()
            ->get();

        return response()->json($data);
    }
}