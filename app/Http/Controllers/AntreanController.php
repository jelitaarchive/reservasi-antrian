<?php

namespace App\Http\Controllers;

use App\Models\Antrian; // Memastikan pemanggilan Model menggunakan "i" (Antrian)
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

    // 2. Proses Simpan Antrian (ANTI-SPAM & FIX NULL VALUE)
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

        $pathDokumen = null;
        if ($request->hasFile('dokumen')) {
            // Menyimpan file ke dalam folder: storage/app/public/dokumen_antrian
            $pathDokumen = $request->file('dokumen')->store('dokumen_antrian', 'public');
        }

        $user = Auth::user();
        $hariIni = Carbon::today()->toDateString();

        // [KUNCI ANTI-SPAM]: Cek apakah user sudah punya antrian aktif (menunggu/melayani) HARI INI
        $antrianEksis = Antrian::where('email', $user->email)
                                ->whereDate('tanggal_antrian', $hariIni)
                                ->whereIn('status', ['menunggu', 'melayani']) // Sesuai ENUM database baru
                                ->first();

        // Kalau sudah ada antrian aktif, langsung oper ke monitoring tanpa membuat data ganda
        if ($antrianEksis) {
            return redirect()->route('monitoring.antrian')->with('info', 'Anda mendatangi kembali antrian aktif Anda.');
        }

        // Kalau belum ada, buat baris baru di database
        Antrian::create([
            'nama'             => $user->name,
            'nim'              => $user->nim ?? 'ST02023030505', 
            'email'            => $user->email,
            'whatsapp'         => $request->whatsapp ?? '',
            
            // FIX: Mengambil nilai input 'jenis_layanan', jika kosong otomatis diset 'Umum' agar tidak eror SQL
            'jenis_layanan'    => $request->jenis_layanan ?? 'Umum', 
            
            'kategori_layanan' => $request->kategori_layanan,
            'waktu_layanan'    => $request->waktu_layanan,
            'nomor_antrian'    => $request->nomor_antrian,
            'tanggal_antrian'  => $hariIni,
            'status'           => 'menunggu', // Status default awal masuk database
            'dokumen'          => $request->file('dokumen'),
        ]);

        return redirect()->route('monitoring.antrian')->with('success', 'Antrian berhasil ditambahkan!');
    }

    // 3. Halaman Monitoring Antrian (REAL-TIME & DINAMIS DARI DATABASE)
    public function monitoring()
    {
        $user = Auth::user();
        $hariIni = Carbon::today()->toDateString();

        // A. Ambil data antrian aktif milik mahasiswa yang sedang login hari ini
        $antrianUser = Antrian::where('email', $user->email)
                            ->whereDate('tanggal_antrian', $hariIni)
                            ->whereIn('status', ['menunggu', 'melayani'])
                            ->latest()
                            ->first();

        // Atur nilai default / fallback awal
        $sisaAntrian = 0;
        $nomorDilayaniText = 'Belum Ada';

        // B. Jika mahasiswa tersebut memiliki antrian aktif, hitung sisa antrian di depannya secara presisi
        if ($antrianUser) {
            // Sisa antrian = menghitung berapa banyak antrian 'menunggu' yang ID-nya lebih kecil (lebih dulu terdaftar) daripada ID antrian user
            $sisaAntrian = Antrian::whereDate('tanggal_antrian', $hariIni)
                                    ->where('status', 'menunggu')
                                    ->where('id', '<', $antrianUser->id)
                                    ->count();
        }

        // C. Cari nomor antrian berapa yang SAAT INI sedang dipanggil/dilayani oleh Admin di loket
        $antrianSedangDilayani = Antrian::whereDate('tanggal_antrian', $hariIni)
                                        ->where('status', 'melayani')
                                        ->first();

        if ($antrianSedangDilayani) {
            // Jika ada yang berstatus melayani, ambil nomor antriannya langsung dari DB (Contoh: A-04)
            $nomorDilayaniText = $antrianSedangDilayani->nomor_antrian;
        } else {
            // Jika tidak ada yang berstatus melayani, cari antrian terakhir yang barusan 'selesai'
            $antrianTerakhirSelesai = Antrian::whereDate('tanggal_antrian', $hariIni)
                                            ->where('status', 'selesai')
                                            ->latest()
                                            ->first();
            if ($antrianTerakhirSelesai) {
                $nomorDilayaniText = $antrianTerakhirSelesai->nomor_antrian . ' (Selesai)';
            }
        }

        // D. Ambil seluruh daftar urutan antrian aktif hari ini untuk list tabel di bagian bawah halaman
        $daftarAntrian = Antrian::whereDate('tanggal_antrian', $hariIni)
                                ->whereIn('status', ['menunggu', 'melayani'])
                                ->oldest()
                                ->get();

        return view('monitoring', compact('antrianUser', 'sisaAntrian', 'nomorDilayaniText', 'daftarAntrian'));
    }
}