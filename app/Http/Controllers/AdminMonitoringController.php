<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class AdminMonitoringController extends Controller
{
    public function index()
    {
        $data = [
            'sedangDilayani' => Antrian::diproses()->first(),
            'sisaAntrian' => Antrian::menunggu()->count(),
            'antrianBerikutnya' => Antrian::menunggu()->orderBy('nomor_antrian', 'asc')->limit(4)->get()
        ];
        return view('admin.monitoring-antrian', $data);
    }

    public function panggilBerikutnya()
    {
        // 1. Selesaikan yang sedang dilayani (jika ada)
        Antrian::diproses()->update(['status' => 'Selesai']);

        // 2. Ambil antrian menunggu teratas dan jadikan 'Diproses'
        $next = Antrian::menunggu()->orderBy('nomor_antrian', 'asc')->first();
        if ($next) {
            $next->update(['status' => 'Diproses']);
        }

        return redirect()->back()->with('success', 'Antrian berhasil dipanggil!');
    }
}
