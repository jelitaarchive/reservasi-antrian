<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QueueHistory;
use Illuminate\Support\Facades\Auth;

class QueueHistoryController extends Controller
{
    public function index()
    {
        // Ambil data riwayat yang HANYA dimiliki oleh user yang sedang login saat ini
        $histories = QueueHistory::where('user_id', Auth::id())
                                 ->latest()
                                 ->get();

        return view('riwayat-antrian', compact('histories'));
    }
}