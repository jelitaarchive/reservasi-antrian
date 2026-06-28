<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Query langsung ke tabel antrians tanpa JOIN karena data nama sudah ada di sana
        $riwayatAntrean = DB::table('antrians')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->paginate(10);

        return view('admin.laporan-pdf', compact('riwayatAntrean', 'bulan', 'tahun'));
    }

    public function downloadPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Ambil data penuh untuk cetak PDF
        $dataLaporan = DB::table('antrians')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        $namaBulan = date('F', mktime(0, 0, 0, $bulan, 10));

        $pdf = Pdf::loadView('admin.cetak-laporan-pdf', [
            'dataLaporan' => $dataLaporan,
            'bulan' => $namaBulan,
            'tahun' => $tahun
        ]);

        return $pdf->download("Laporan_Antrean_{$namaBulan}_{$tahun}.pdf");
    }
}