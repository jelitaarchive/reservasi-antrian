<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('admin.dashboard');
        }

        // 3. JIKA USER ADALAH MAHASISWA -> Jalankan Logika Lama Kamu
        $search = $request->query('search'); // Mengambil input 'search' dari URL
        
        $layanans = [
            ['nama' => 'Pembayaran'],
            ['nama' => 'Administrasi'],
        ];

        $daftarAntrian = Antrian::where('tanggal_antrian', date('Y-m-d'))
                                ->oldest()
                                ->get()
                                ->unique('email')
                                ->take(4);

        // Kirimkan variabel ke view dashboard milik mahasiswa
        return view('dashboard', compact('layanans', 'search', 'daftarAntrian'));
    }
}