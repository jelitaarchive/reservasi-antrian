<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAntreanController extends Controller
{
    public function index()
    {
        // Mengambil semua data antrian dari database
        $antrian = Antrian::all(); 

        // Mengembalikan data dalam bentuk JSON agar bisa dibaca Flutter & Web App
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua antrian',
            'data'    => $antrian
        ], 200);
    }

    public function show($id)
    {
        // Cari data antrian berdasarkan ID
        $antrian = Antrian::find($id);

        // Jika data tidak ditemukan, kembalikan respons error 404
        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Data antrian tidak ditemukan!'
            ], 404);
        }

        // Jika ditemukan, kembalikan data antrian tersebut
        return response()->json([
            'success' => true,
            'message' => 'Detail data antrian',
            'data'    => $antrian
        ], 200);
    }

    /**
     * Menyimpan antrian baru yang dikirim dari Aplikasi Flutter (Mahasiswa)
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari Flutter / Postman
        $request->validate([
            'layanan' => 'required|string',
        ]);

        // 2. Mengambil data user yang sedang login via Auth (Token)
        $user = auth()->user(); 
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Silakan login terlebih dahulu.'
            ], 401);
        }

        // 3. Generate nomor antrian otomatis (Contoh simpel: hitung antrian hari ini + 1)
        $today = Carbon::today()->toDateString();
        $totalAntrianHariIni = Antrian::where('tanggal_antrian', $today)->count();
        $nomorAntrian = $totalAntrianHariIni + 1;

        // 4. Simpan ke database sesuai struktur tabel Anda
        $antrian = Antrian::create([
            'user_id'         => $user->id,
            'nomor_antrian'   => $nomorAntrian,
            'nama'            => $user->name,       // Mengambil dari data user login
            'nim'             => $user->nim,        // Mengambil dari data user login
            'layanan'         => $request->layanan, // Diambil dari input body
            'tanggal_antrian' => $today,
            'status'          => 'menunggu',        // Default status
        ]);

        // 5. Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Antrian berhasil ditambahkan!',
            'data'    => $antrian
        ], 201);
    }
}