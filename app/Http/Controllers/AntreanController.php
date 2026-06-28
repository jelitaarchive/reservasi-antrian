<?php

namespace App\Http\Controllers;

use App\Models\Antrian; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AntreanController extends Controller
{
    // 1. Halaman Tambah Antrian
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        
        $antrian = Antrian::where('email', Auth::user()->email)
                            ->whereDate('tanggal_antrian', $hariIni)
                            ->latest()
                            ->first();

        return view('tambah-antrian', compact('antrian'));
    }

    // 2. Proses Simpan Antrian (ANTI-SPAM & FIX LOCAL DISK BUG)
    public function store(Request $request)
    {   
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required|email',
            'whatsapp' => 'required',
            'kategori_layanan' => 'required',
            'waktu_layanan' => 'required',
            'nomor_antrian' => 'required',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // FIX: Inisialisasi awal path dokumen
        $pathDokumen = null;
        
        if ($request->hasFile('dokumen')) {
            // Menyimpan file asli secara aman ke folder: storage/app/public/dokumen_antrian
            // Dan menghasilkan string path pendek bersih seperti: "dokumen_antrian/nama_acak.pdf"
            $pathDokumen = $request->file('dokumen')->store('dokumen_antrian', 'public');
        }

        $user = Auth::user();
        $hariIni = Carbon::today()->toDateString();

        // [KUNCI ANTI-SPAM]: Cek apakah user sudah punya antrian aktif HARI INI
        $antrianEksis = Antrian::where('email', $user->email)
                                ->whereDate('tanggal_antrian', $hariIni)
                                ->whereIn('status', ['menunggu', 'melayani']) 
                                ->first();

        // Kalau sudah ada antrian aktif, oper ke monitoring tanpa duplikasi data
        if ($antrianEksis) {
            return redirect()->route('monitoring.antrian')->with('info', 'Anda mendatangi kembali antrian aktif Anda.');
        }

        // Simpan baris baru ke MySQL dengan path dokumen yang bersih
        Antrian::create([
            'nama'             => $user->name,
            'nim'              => $user->nim ?? 'ST02023030505', 
            'email'            => $user->email,
            'whatsapp'         => $request->whatsapp ?? '',
            'jenis_layanan'    => $request->jenis_layanan ?? 'Umum', 
            'kategori_layanan' => $request->kategori_layanan,
            'waktu_layanan'    => $request->waktu_layanan,
            'nomor_antrian'    => $request->nomor_antrian,
            'tanggal_antrian'  => $hariIni,
            'status'           => 'menunggu', 
            
            // FIX UTAMA: Menggunakan $pathBersih hasil upload, bukan $request->file('dokumen') lagi!
            'dokumen'          => $pathDokumen, 
        ]);

        return redirect()->route('monitoring.antrian')->with('success', 'Antrian berhasil ditambahkan!');
    }

    // 3. Halaman Monitoring Antrian
    public function monitoring()
    {
        $user = Auth::user();
        $hariIni = Carbon::today()->toDateString();

        // A. Ambil data antrian aktif milik mahasiswa hari ini
        $antrianUser = Antrian::where('email', $user->email)
                            ->whereDate('tanggal_antrian', $hariIni)
                            ->whereIn('status', ['menunggu', 'melayani'])
                            ->latest()
                            ->first();

        $sisaAntrian = 0;
        $nomorDilayaniText = 'Belum Ada';

        // B. Hitung sisa antrian di depannya secara presisi
        if ($antrianUser) {
            $sisaAntrian = Antrian::whereDate('tanggal_antrian', $hariIni)
                                    ->where('status', 'menunggu')
                                    ->where('id', '<', $antrianUser->id)
                                    ->count();
        }

        // C. Cari nomor antrian yang saat ini berstatus 'melayani'
        $antrianSedangDilayani = Antrian::whereDate('tanggal_antrian', $hariIni)
                                        ->where('status', 'melayani')
                                        ->first();

        if ($antrianSedangDilayani) {
            $nomorDilayaniText = $antrianSedangDilayani->nomor_antrian;
        } else {
            $antrianTerakhirSelesai = Antrian::whereDate('tanggal_antrian', $hariIni)
                                            ->where('status', 'selesai')
                                            ->latest()
                                            ->first();
            if ($antrianTerakhirSelesai) {
                $nomorDilayaniText = $antrianTerakhirSelesai->nomor_antrian . ' (Selesai)';
            }
        }

        // D. Ambil seluruh daftar urutan antrian aktif hari ini
        $daftarAntrian = Antrian::whereDate('tanggal_antrian', $hariIni)
                                ->whereIn('status', ['menunggu', 'melayani'])
                                ->oldest()
                                ->get();

        return view('monitoring', compact('antrianUser', 'sisaAntrian', 'nomorDilayaniText', 'daftarAntrian'));
    }
}