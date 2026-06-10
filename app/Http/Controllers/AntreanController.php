<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntreanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required',
            'waktu_layanan' => 'required',
            'kode_antrian'  => 'required',
        ]);

        Antrian::create([
            'user_id'       => Auth::id(),
            'jenis_layanan' => $request->jenis_layanan,
            'waktu_layanan' => $request->waktu_layanan,
            'kode_antrian'  => $request->kode_antrian,
            'status'        => 'menunggu',
        ]);

        return redirect()->route('monitoring')->with('success', 'Antrian berhasil ditambahkan!');
    }

    public function index()
    {
        // Mengambil antrian terbaru user yang login
        $antrian = \App\Models\Antrian::where('user_id', auth()->id())
                                    ->latest()
                                    ->first();

        return view('tambah-antrian', compact('antrian'));
    }
}