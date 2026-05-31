<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QueueHistory; // Pastikan Model ini sudah dibuat
use Carbon\Carbon;

class QueueHistoryController extends Controller
{
    public function index()
    {
        // 1. Ambil data riwayat milik mahasiswa yang sedang login (jika pakai auth)
        // atau ambil semua data riwayat dan urutkan dari yang terbaru
        $histories = QueueHistory::latest()->get();

        // 2. Kirim data ke file blade (misal namanya: resources/views/antrean/riwayat.blade.php)
        return view('riwayat', compact('histories'));
    }
}