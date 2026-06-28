<?php

namespace App\Http\Controllers;

use App\Models\Antrian; 
use Illuminate\Http\Request;
use App\Models\QueueHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Http; // DITAMBAHKAN: Untuk hit REST API ke Mobile

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard admin.
     */
    public function index()
    {
        $dataAdmin = User::where('role', 'admin')->latest()->paginate(7);
        return view('admin.dashboard', compact('dataAdmin'));
    }

    /**
     * Tampilkan halaman kelola antrian secara dinamis dengan statistik dan filter.
     */
    public function kelolaAntrian(Request $request)
    {
        $hariIni = Carbon::today()->toDateString();

        $search = $request->query('search');
        $layanan = $request->query('layanan');

        $menunggu       = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'menunggu')->count();
        $sedangMelayani = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'melayani')->count();
        $selesaiHariIni = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'selesai')->count();
        $dibatalkan     = Antrian::whereDate('tanggal_antrian', $hariIni)->where('status', 'batal')->count();

        $query = Antrian::whereDate('tanggal_antrian', $hariIni)->oldest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($layanan && $layanan !== 'Semua Layanan') {
            $query->where('jenis_layanan', $layanan);
        }

        $daftarAntrian = $query->get();

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

    /**
     * Update status antrian dan sinkronisasi ke REST API Mobile
     */
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

        // 1. Update status di tabel utama antrian lokal (Web)
        $antrian->status = $status;
        $antrian->save();

        // 2. MODIFIKASI: Kirim data status terbaru ke REST API Mobile via HTTP POST
        try {
            // Mapping status dari web 'melayani' ke bahasa mobile 'Sedang Dilayani' agar match dengan UI Flutter
            $statusMobile = $status;
            if ($status === 'melayani') {
                $statusMobile = 'Sedang Dilayani';
            } else {
                $statusMobile = ucfirst($status); // Mengubah 'selesai' jadi 'Selesai', 'batal' jadi 'Batal'
            }

            // Ganti URL ini dengan URL domain/IP lokal server API Mobile kamu saat ini
            $apiUrl = 'http://localhost/api_mobile/update_status.php'; 

            Http::timeout(5)->post($apiUrl, [
                'nomor_antrian'  => $antrian->nomor_antrian,
                'status_antrian' => $statusMobile,
            ]);
        } catch (\Exception $e) {
            // Jika API Mobile mati, web tidak crash/error, melainkan tetap lanjut save log
            logger("Gagal sinkronisasi ke API Mobile: " . $e->getMessage());
        }

        // Jika status diubah ke 'selesai' atau 'batal', masukkan ke queue_histories
        if (in_array($status, ['selesai', 'batal'])) {
            
            $user = DB::table('users')->where('nim', $antrian->nim)->first();
            $userId = $user ? $user->id : null;

            QueueHistory::create([
                'user_id'     => $userId,
                'title'       => $antrian->jenis_layanan ?? 'Pelayanan Kampus',
                'status'      => $status, 
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

    public function storeAntrianFromMobile(Request $request)
    {
        // Validasi data kiriman dari mobile backend
        $request->validate([
            'nomor_antrian' => 'required',
            'nama'          => 'required',
            'nim'           => 'required',
            'jenis_layanan' => 'required',
        ]);

        try {
            // Masukkan data ke model Antrian milik Web Admin
            $antrian = new Antrian();
            $antrian->nomor_antrian   = $request->nomor_antrian;
            $antrian->nama            = $request->nama;
            $antrian->nim             = $request->nim;
            $antrian->jenis_layanan   = $request->jenis_layanan;
            $antrian->tanggal_antrian = now()->toDateString();
            $antrian->status          = 'menunggu'; // Default awal antrean baru
            $antrian->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Antrean mobile berhasil masuk ke database Web Admin!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan ke Web Admin: ' . $e->getMessage()
            ], 500);
        }
    }
}