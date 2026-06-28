<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVerifikasiController extends Controller
{
    /**
     * Menampilkan halaman verifikasi berkas admin
     */
    public function index()
    {
        // Ambil semua data dari tabel antrians tanpa pengecualian NULL agar antrian baru langsung masuk
        // Gunakan paginate(7) sesuai dengan template view kamu sebelumnya
        $dataBerkas = DB::table('antrians')
            ->latest()
            ->paginate(7);

        return view('admin.verifikasi-berkas', compact('dataBerkas'));
    }

    /**
     * Memperbarui status antrian/berkas (Setujui / Tolak)
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status demi keamanan data database
        $request->validate([
            'status' => 'required|in:menunggu,selesai,batal' // sesuaikan dengan enum status di database kamu
        ]);

        // Update status langsung menggunakan Query Builder query ke id yang dituju
        $updated = DB::table('antrians')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Status berkas berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status berkas.');
    }
}