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
}