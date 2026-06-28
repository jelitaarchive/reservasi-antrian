<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    // ==========================================
    // FUNGSI UNTUK MAHASISWA (Web Form)
    // ==========================================

    /**
     * Menyimpan antrian baru dari Form Web Mahasiswa beserta file dokumen
     */
    public function store(Request $request)
    {
        // 1. Validasi file berkas
        $request->validate([
            'jenis_layanan' => 'required|string',
            'dokumen'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Inisialisasi variabel path
        $pathBersih = null;

        // 2. Proses upload file ke folder 'dokumen_antrian'
        if ($request->hasFile('dokumen')) {
            // Ini akan memindahkan file fisik ke storage/app/public/dokumen_antrian
            // Dan menghasilkan string bersih seperti: "dokumen_antrian/nama_acak.pdf"
            $pathBersih = $request->file('dokumen')->store('dokumen_antrian', 'public');
        }

        // 3. Simpan data ke MySQL
        $antrian = Antrian::create([
            'user_id'           => auth()->id(),
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
            'status'            => $request->status ?? 'Menunggu',
            
            // PENTING: ISI PAKAI VARIABEL $pathBersih, JANGAN PAKAI $request->dokumen!
            'dokumen'           => $pathBersih, 
            
            'bukti_transfer'    => $request->bukti_transfer
        ]);

        return redirect()->back()->with('success', 'Antrian dan berkas berhasil disimpan!');
    }

    /**
     * Menampilkan riwayat antrian berdasarkan NIM mahasiswa
     */
    public function riwayat($nim)
    {
        $data = Antrian::where('nim', $nim)->latest()->get();
        return response()->json($data);
    }

    // ==========================================
    // FUNGSI UNTUK CRUD ADMIN
    // ==========================================

    // 1. READ ALL - Admin melihat semua antrian dari seluruh mahasiswa
    public function index()
    {
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

    // 3. UPDATE - Admin mengubah status atau data lainnya
    public function update(Request $request, $id)
    {
        $antrian = Antrian::find($id);

        if (!$antrian) {
            return response()->json([
                'message' => 'Data antrian tidak ditemukan'
            ], 404);
        }

        $antrian->update($request->all());

        return response()->json([
            'message' => 'Antrian berhasil diperbarui oleh Admin',
            'data'    => $antrian
        ], 200);
    }

    // 4. DELETE - Admin menghapus data antrian
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