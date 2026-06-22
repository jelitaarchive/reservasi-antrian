<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
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
    }
}