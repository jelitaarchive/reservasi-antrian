<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

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
}