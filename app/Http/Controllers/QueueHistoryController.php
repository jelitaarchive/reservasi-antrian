<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;

class QueueHistoryController extends Controller
{
    public function index()
    {
        // Ambil data riwayat berdasarkan EMAIL user yang sedang login
        $histories = Antrian::where('email', Auth::user()->email) 
            ->whereIn('status', ['selesai', 'batal', 'dibatalkan', 'Selesai', 'Batal', 'Dibatalkan'])
            ->latest()
            ->get();

        return view('riwayat-antrian', compact('histories'));
    }
}