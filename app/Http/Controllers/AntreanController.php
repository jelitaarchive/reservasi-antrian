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

    // 2. Proses Simpan Antrian (URUT OTOMATIS & ANTI-SPAM)
        public function store(Request $request)
        {   
            // 1. Validasi Input (Hapus 'nomor_antrian' dari required karena sekarang digenerate otomatis)
            $request->validate([
                'nama' => 'required',
                'nim' => 'required',
                'email' => 'required|email',
                'whatsapp' => 'required',
                'kategori_layanan' => 'required', // Misal inputnya bernilai 'A' atau 'B'
                'waktu_layanan' => 'required',
                'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $pathDokumen = null;
            if ($request->hasFile('dokumen')) {
                $pathDokumen = $request->file('dokumen')->store('dokumen_antrian', 'public');
            }

            $user = Auth::user();
            $hariIni = Carbon::today()->toDateString();

            // 2. KUNCI ANTI-SPAM: Cek apakah user sudah punya antrian aktif hari ini
            $antrianEksis = Antrian::where('email', $user->email)
                                    ->whereDate('tanggal_antrian', $hariIni)
                                    ->whereIn('status', ['menunggu', 'melayani'])
                                    ->first();

            if ($antrianEksis) {
                return redirect()->route('monitoring.antrian')->with('info', 'Anda mendatangi kembali antrian aktif Anda.');
            }

            // 3. LOGIKA GENERATE NOMOR ANTREAN URUT (A-001, A-002, dst)
            // Ambil huruf depan dari kategori (misal dari "A" atau bisa kamu sesuaikan sendiri kodenya)
            $prefix = ($request->waktu_layanan === '08.00-12.00 WIB') ? 'A' : 'B';

            // Cari nomor antrean terakhir dengan prefix tersebut pada hari ini
            $antrianTerakhir = Antrian::whereDate('tanggal_antrian', $hariIni)
                                        ->where('nomor_antrian', 'LIKE', $prefix . '-%')
                                        ->orderBy('nomor_antrian', 'desc')
                                        ->first();

            if ($antrianTerakhir) {
                // Mengambil 3 angka terakhir dibelakang tanda strip (A-001 -> ambil 001)
                $nomorTerakhir = (int) substr($antrianTerakhir->nomor_antrian, 2);
                $nomorBaru = $nomorTerakhir + 1;
            } else {
                $nomorBaru = 1;
            }

            // Satukan format menjadi A-001, A-002, dst
            $nomorAntrianFinal = $prefix . '-' . str_pad($nomorBaru, 3, '0', STR_PAD_LEFT);

            // 4. Simpan ke Database
            Antrian::create([
                'nama'             => $user->name,
                'nim'              => $user->nim ?? 'ST02023030505', 
                'email'            => $user->email,
                'whatsapp'         => $request->whatsapp ?? '',
                'jenis_layanan'    => $request->jenis_layanan ?? 'Umum', 
                'kategori_layanan' => $request->kategori_layanan,
                'waktu_layanan'    => $request->waktu_layanan,
                'nomor_antrian'    => $nomorAntrianFinal, // Menggunakan nomor urut otomatis hasil generate
                'tanggal_antrian'  => $hariIni,
                'status'           => 'menunggu', 
                'dokumen'          => $pathDokumen, 
            ]);

            return redirect()->route('monitoring.antrian')->with('success', 'Antrian berhasil ditambahkan dengan nomor ' . $nomorAntrianFinal);
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