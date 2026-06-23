<?php

namespace App\Http\Controllers;

// WAJIB: Pastikan baris impor Model Layanan ini ada di sini!
use App\Models\Layanan; 
use Illuminate\Http\Request;

class AdminLayananController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel layanans
        $daftarLayanan = Layanan::all();

        // Mengarahkan ke file blade di dalam folder admin
        return view('admin.kelola-layanan', compact('daftarLayanan'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'estimasi' => 'required|string|max:50',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // 2. Simpan ke Database
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'estimasi' => $request->estimasi,
            'status' => $request->status,
        ]);

        // 3. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Layanan baru berhasil ditambahkan!');
    }
}