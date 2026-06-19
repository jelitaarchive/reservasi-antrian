<?php

namespace App\Http\Controllers;

use App\Models\Antrian; // FIX: Sekarang mengarah ke Model Antrian.php kamu yang pakai "i"
use Illuminate\Http\Request;
use App\Models\QueueHistory;
use Illuminate\Support\Facades\DB;
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
        $statusValid = ['menunggu', 'melayani', 'selesai', 'batal'];
        if (!in_array($status, $statusValid)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $antrian = Antrian::findOrFail($id);

        if ($status === 'melayani') {
            Antrian::where('status', 'melayani')
                ->where('jenis_layanan', $antrian->jenis_layanan)
                ->update(['status' => 'selesai']);
        }

        // Update status di tabel utama antrian
        $antrian->status = $status;
        $antrian->save();

        // Jika status diubah ke 'selesai' atau 'batal', masukkan ke queue_histories
        if (in_array($status, ['selesai', 'batal'])) {
            
            $user = DB::table('users')->where('nim', $antrian->nim)->first();
            $userId = $user ? $user->id : null;

            QueueHistory::create([
                'user_id'     => $userId,
                'title'       => $antrian->jenis_layanan ?? 'Pelayanan Kampus',
                'status'      => $status, // <--- SEKARANG STATUSNYA SUDAH DICATAT ('selesai' atau 'batal')
                'date'        => now()->toDateString(), 
                'start_time'  => $antrian->created_at ? $antrian->created_at->toTimeString() : now()->toTimeString(), 
                'end_time'    => now()->toTimeString(), 
                'description' => $antrian->kategori_layanan ?? 'Antrean dengan nomor ' . $antrian->nomor_antrian . ' status: ' . $status,
                'dokumen'     => $antrian->dokumen,
            ]);
        }

        $pesan = 'Status antrian ' . $antrian->nomor_antrian . ' berhasil diperbarui.';
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