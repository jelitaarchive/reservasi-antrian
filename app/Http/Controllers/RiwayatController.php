<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Antrian::query();

        // Filter layanan
        if ($request->layanan) {
            $query->where(
                'jenis_layanan',
                $request->layanan
            );
        }

        // hanya yang selesai
        $query->where(
            'status',
            'Selesai'
        );

        $riwayat = $query
                    ->latest()
                    ->paginate(10);

        return view(
            'admin.riwayat-antrian',
            compact('riwayat')
        );
    }
    public function exportPdf(Request $request)
    {
        $query = Antrian::query();

        if ($request->layanan) {
            $query->where('jenis_layanan', $request->layanan);
        }

        $query->where('status', 'Selesai');

        $riwayat = $query->latest()->get();

        $pdf = Pdf::loadView(
            'admin.riwayat-antrian-pdf',
            compact('riwayat')
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Riwayat_Antrian.pdf');
    }
}