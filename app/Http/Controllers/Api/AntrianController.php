<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Support\Facades\Http; // FIX: Diubah dari Https ke Http bawaan Laravel
=======
>>>>>>> 7533c789fe1873f8825cc52f4d67306ded12525d
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
<<<<<<< HEAD
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
=======
    // ==========================================
    // FUNGSI UNTUK MAHASISWA (Sudah Ada)
    // ==========================================

    public function store(Request $request)
    {
        $antrian = Antrian::create([
            'user_id'           => $request->user_id,
            'nama'              => $request->nama,
            'nim'               => $request->nim,
            'email'             => $request->email,
            'whatsapp'          => $request->whatsapp,
            'jenis_layanan'     => $request->jenis_layanan,
            'kategori_layanan'  => $request->kategori_layanan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'waktu_layanan'     => $request->waktu_layanan,
            'nomor_antrian'     => $request->nomor_antrian,
            'tanggal_antrian'   => now(),
            'status'            => $request->status ?? 'menunggu', // Beri default 'menunggu' jika status kosong
            'bukti_transfer'    => $request->bukti_transfer
        ]);

        return response()->json([
            'message' => 'berhasil',
            'data'    => $antrian
        ]);
    }

    public function riwayat($nim)
    {
        $data = Antrian::where('nim', $nim)->latest()->get();
        return response()->json($data);
    }

    // ==========================================
    // FUNGSI TAMBAHAN UNTUK CRUD ADMIN (Wajib Ditambahkan)
    // ==========================================

    // 1. READ ALL - Admin melihat semua antrian dari seluruh mahasiswa
    public function index()
    {
        // Mengambil semua data antrian, diurutkan dari yang terbaru
        $data = Antrian::latest()->get(); 
        
        return response()->json([
            'message' => 'Berhasil mengambil semua data antrian',
            'data'    => $data
        ], 200);
    }

    // 2. READ DETAIL - Admin melihat detail satu antrian berdasarkan ID
    public function show($id)
    {
        $antrian = Antrian::find($id);

        if (!$antrian) {
            return response()->json([
                'message' => 'Data antrian tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil detail antrian',
            'data'    => $antrian
        ], 200);
    }

    // 3. UPDATE - Admin mengubah status (misal: diproses/selesai) atau data lainnya
    public function update(Request $request, $id)
    {
        $antrian = Antrian::find($id);

        if (!$antrian) {
            return response()->json([
                'message' => 'Data antrian tidak ditemukan'
            ], 404);
        }

        // Admin bisa mengupdate status, nomor_antrian, dll.
        $antrian->update($request->all());

        return response()->json([
            'message' => 'Antrian berhasil diperbarui oleh Admin',
            'data'    => $antrian
        ], 200);
    }

    // 4. DELETE - Admin menghapus data antrian jika dibatalkan/salah input
    public function destroy($id)
    {
        $antrian = Antrian::find($id);

        if (!$antrian) {
            return response()->json([
                'message' => 'Data antrian tidak ditemukan'
            ], 404);
        }

        $antrian->delete();

        return response()->json([
            'message' => 'Antrian berhasil dihapus oleh Admin'
        ], 200);
>>>>>>> 7533c789fe1873f8825cc52f4d67306ded12525d
    }
}