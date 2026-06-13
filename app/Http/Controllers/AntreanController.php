<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntreanController extends Controller
{
    // 1. Halaman Tambah Antrian
    public function index()
    {
        $antrian = Antrian::where('email', Auth::user()->email)
                            ->where('tanggal_antrian', date('Y-m-d'))
                            ->latest()
                            ->first();

        return view('tambah-antrian', compact('antrian'));
    }

    // 2. Proses Simpan Antrian (ANTI-SPAM)
    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan'     => 'required',
            'kategori_layanan'  => 'required',
            'waktu_layanan'     => 'required',
            'nomor_antrian'     => 'required',
        ]);

        $user = Auth::user();

        // [KUNCI ANTI-SPAM] Cek apakah user sudah punya antrian aktif hari ini
        $antrianEksis = Antrian::where('email', $user->email)
                                ->where('tanggal_antrian', date('Y-m-d'))
                                ->whereIn('status', ['menunggu', 'dipanggil'])
                                ->first();

        // Kalau sudah ada antrian, langsung oper ke monitoring tanpa create baru!
        if ($antrianEksis) {
            return redirect()->route('monitoring.antrian')->with('info', 'Anda mendatangi kembali antrian aktif Anda.');
        }

        // Kalau belum ada, baru kita buatkan baris baru di database
        Antrian::create([
            'nama'              => $user->name,
            'nim'               => $user->nim ?? 'ST02023030505', 
            'email'             => $user->email,
            'whatsapp'          => $user->whatsapp ?? '',
            'jenis_layanan'     => $request->jenis_layanan,
            'kategori_layanan'  => $request->kategori_layanan,
            'waktu_layanan'     => $request->waktu_layanan,
            'nomor_antrian'     => $request->nomor_antrian,
            'tanggal_antrian'   => date('Y-m-d'),
            'status'            => 'menunggu',
        ]);

        return redirect()->route('monitoring.antrian')->with('success', 'Antrian berhasil ditambahkan!');
    }

    // 3. Halaman Monitoring Antrian (KALKULASI OTOMATIS)
    public function monitoring()
    {
        $user = Auth::user();

        // Ambil data antrian aktif milik user login
        $antrianUser = Antrian::where('email', $user->email)
                            ->where('tanggal_antrian', date('Y-m-d'))
                            ->whereIn('status', ['menunggu', 'dipanggil'])
                            ->latest()
                            ->first();

        // Atur nilai default / fallback
        $sisaAntrian = 0;
        $nomorDilayaniText = 'Belum Ada';

        if ($antrianUser) {
            // Simulasi Sisa Antrian (Kita set statis 1 sesuai request-mu atau dinamis)
            $sisaAntrian = 1; 

            // [KUNCI KALKULASI NOMOR YANG DILAYANI]
            // Mengambil huruf depan (ex: 'B') dan angka belakang (ex: '08')
            $nomorFull = $antrianUser->nomor_antrian; // B-08
            
            if (str_contains($nomorFull, '-')) {
                list($prefix, $angka) = explode('-', $nomorFull); // memisah 'B' dan '08'
                
                // Kurangi angka antrian dengan sisa antrian di depannya (8 - 1 - 1 = 6)
                // Rumus: Angka Sekarang - Sisa Antrian - 1 (karena sisa antrian tidak termasuk yang sedang dilayani)
                $angkaDilayani = (int)$angka - $sisaAntrian - 1;

                if ($angkaDilayani > 0) {
                    // PadString digunakan agar angka tetap berformat dua digit (6 menjadi '06')
                    $nomorDilayaniText = $prefix . '-' . str_pad($angkaDilayani, 2, '0', STR_PAD_LEFT); // B-06
                } else {
                    $nomorDilayaniText = $prefix . '-01'; // Mentok di nomor pertama jika hasil minus
                }
            }
        }

        // Ambil semua daftar urutan antrian umum hari ini (Group by email agar tidak double di list bawah)
        $daftarAntrian = Antrian::where('tanggal_antrian', date('Y-m-d'))
                                ->oldest()
                                ->get()
                                ->unique('email'); // Menghilangkan tampilan duplikat dari spam lama

        return view('monitoring', compact('antrianUser', 'sisaAntrian', 'nomorDilayaniText', 'daftarAntrian'));
    }
}