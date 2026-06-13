<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        // Kirimkan variabel $daftarAntrian bersama dengan $layanans dan $search ke view dashboard
        return view('dashboard', compact('layanans', 'search', 'daftarAntrian'));
    }
}