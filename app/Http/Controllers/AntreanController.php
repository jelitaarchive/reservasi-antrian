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
                            ->latest()
                            ->first();

        return view('tambah-antrian', compact('antrian'));
    }

    // 2. Proses Simpan Antrian (Aksi dari Form)
    public function store(Request $request)
    {
        // Sesuai dengan name input dari view HTML kamu
        $request->validate([
            'jenis_layanan'     => 'required',
            'kategori_layanan'  => 'required',
            'waktu_layanan'     => 'required',
            'nomor_antrian'     => 'required',
        ]);

        $user = Auth::user();

        // Simpan ke database
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

        // Lempar langsung ke halaman monitoring antrian
        return redirect()->route('monitoring.antrian')->with('success', 'Antrian berhasil ditambahkan!');
    }

    // 3. Halaman Monitoring Antrian
    public function monitoring()
    {
        $user = Auth::user();

        // Ambil antrian terbaru milik user aktif hari ini
        $antrianUser = Antrian::where('email', $user->email)
                            ->where('tanggal_antrian', date('Y-m-d'))
                            ->latest()
                            ->first();

        $sedangDilayani = null;
        $sisaAntrian = 0;

        if ($antrianUser) {
            // Ambil antrian paling pertama (paling tua/oldest) yang statusnya masih aktif hari ini
            $sedangDilayani = Antrian::where('kategori_layanan', $antrianUser->kategori_layanan)
                                    ->where('tanggal_antrian', date('Y-m-d'))
                                    ->whereIn('status', ['menunggu', 'dipanggil'])
                                    ->oldest()
                                    ->first();

            // Hitung berapa orang antrian yang id-nya lebih kecil (di depan user)
            $sisaAntrian = Antrian::where('kategori_layanan', $antrianUser->kategori_layanan)
                                  ->where('tanggal_antrian', date('Y-m-d'))
                                  ->where('status', 'menunggu')
                                  ->where('id', '<', $antrianUser->id)
                                  ->count();
        }

        // Ambil daftar 4 antrian umum hari ini buat list bawah
        $daftarAntrian = Antrian::where('tanggal_antrian', date('Y-m-d'))
                                ->oldest()
                                ->take(4)
                                ->get();

        return view('monitoring', compact('antrianUser', 'sedangDilayani', 'sisaAntrian', 'daftarAntrian'));
    }
}