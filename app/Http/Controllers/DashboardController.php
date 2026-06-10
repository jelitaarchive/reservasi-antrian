<?php

namespace App\Http\Controllers;

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

        return view('dashboard', compact('layanans', 'search'));
    }
}