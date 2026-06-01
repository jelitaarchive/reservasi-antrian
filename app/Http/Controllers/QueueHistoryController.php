<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QueueHistory;
use Carbon\Carbon;

class QueueHistoryController extends Controller
{
    public function index()
    {
        // Ambil data riwayat antrian dari database
        $histories = QueueHistory::latest()->get();

        // PASTIKAN MENGARAH KE 'riwayat-antrian' SESUAI DENGAN FILE BLADE ANDA
        return view('riwayat-antrian', compact('histories'));
    }
}