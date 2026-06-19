<?php

namespace App\Http\Controllers;

use App\Models\Antrian; // FIX: Sekarang mengarah ke Model Antrian.php kamu yang pakai "i"
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard admin.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Tampilkan halaman kelola antrian secara dinamis dengan statistik dan filter.
     */
    public function kelolaAntrian(Request $request)
    {
        $hariIni = Carbon::today()->toDateString();

        // 1. Ambil data parameter query dari URL untuk pencarian & filter
        $search = $request->query('search');
        $layanan = $request->query('layanan');

        // 2. Hitung statistik hari ini berdasarkan Model Antrian
        $menunggu       = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'menunggu')->count();
        $sedangMelayani = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'melayani')->count();
        $selesaiHariIni = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'selesai')->count();
        $dibatalkan     = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'batal')->count();

        // 3. Bangun query dasar untuk mengambil daftar antrian hari ini
        $query = Antrian::whereDate('tanggal_antrian', $hariIni)->oldest();

        // Filter: Jika admin mencari nama atau NIM tertentu
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter: Jika admin memilih jenis layanan tertentu
        if ($layanan && $layanan !== 'Semua Layanan') {
            $query->where('jenis_layanan', $layanan);
        }

        // Eksekusi dapatkan hasil akhir data antrian
        $daftarAntrian = $query->get();

        // 4. Kirim seluruh data ke view admin.kelola-antrian
        return view('admin.kelola-antrian', compact(
            'daftarAntrian',
            'menunggu',
            'sedangMelayani',
            'selesaiHariIni',
            'dibatalkan',
            'search',
            'layanan'
        ));
    }

    public function updateStatus($id, $status)
    {
        // Validasi agar status yang dimasukkan tidak ngawur
        $statusValid = ['menunggu', 'melayani', 'selesai', 'batal'];
        if (!in_array($status, $statusValid)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Cari data antrian berdasarkan ID
        $antrian = Antrian::findOrFail($id);

        // Jika admin menekan tombol panggil ('melayani'), 
        // opsional: ubah antrian lain yang masih 'melayani' di loket tersebut menjadi 'selesai'
        if ($status === 'melayani') {
            Antrian::where('status', 'melayani')
                ->where('jenis_layanan', $antrian->jenis_layanan)
                ->update(['status' => 'selesai']);
        }

        // Update status antrian ini
        $antrian->status = $status;
        $antrian->save();

        // Siapkan pesan notifikasi yang manis untuk flash message
        $pesan = 'Status antrian ' . $antrian->nomor_antrian . ' berhasil diperbarui ';
        if ($status === 'melayani') $pesan .= 'menjadi Sedang Dilayani.';
        if ($status === 'selesai') $pesan .= 'menjadi Selesai.';
        if ($status === 'batal') $pesan .= 'dan telah Dibatalkan.';

        return redirect()->back()->with('success', $pesan);
    }

    /**
     * Menghapus data antrian secara permanen (CRUD - Delete)
     */
    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);
        $nomor = $antrian->nomor_antrian;
        $antrian->delete();

        return redirect()->back()->with('success', 'Data antrian ' . $nomor . ' berhasil dihapus permanen dari database.');
    }
}