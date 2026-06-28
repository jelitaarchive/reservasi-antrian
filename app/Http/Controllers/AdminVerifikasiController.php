<?php

namespace App\Http\Controllers;

use App\Models\Antrian; // Memanggil model Antrian
use Illuminate\Http\Request;

class AdminVerifikasiController extends Controller
{
    /**
     * Menampilkan halaman daftar berkas mahasiswa yang masuk ke Admin
     */
    public function index()
    {
        // Mengambil data antrian yang kolom 'dokumen'-nya tidak kosong (artinya mahasiswa mengunggah file)
        // 'with('user')' digunakan untuk memuat data relasi mahasiswa (NIM & Nama)
        $dataBerkas = Antrian::whereNotNull('dokumen')
                             ->with('user') 
                             ->latest() // Menampilkan berkas terbaru di urutan paling atas
                             ->paginate(7);

        // Mengirimkan variabel $dataBerkas ke file view 'admin/verifikasi-berkas.blade.php'
        return view('admin.verifikasi-berkas', compact('dataBerkas'));
    }

    /**
     * Memproses aksi tombol "Setujui" atau "Tolak" dari halaman verifikasi berkas
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi status yang dikirimkan dari form tombol Admin
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        // 2. Cari data antrian berdasarkan ID, jika tidak ketemu akan memunculkan error 404
        $antrian = Antrian::findOrFail($id);
        
        // 3. Update kolom status di database sesuai tombol yang diklik Admin
        $antrian->status = $request->status;
        $antrian->save();

        // 4. Redirect kembali ke halaman verifikasi berkas dengan pesan sukses di sisi admin
        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui oleh Admin!');
    }
}