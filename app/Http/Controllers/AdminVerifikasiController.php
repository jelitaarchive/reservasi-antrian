<?php

namespace App\Http\Controllers;

use App\Models\Antrian; // Gunakan model Antrian
use Illuminate\Http\Request;

class AdminVerifikasiController extends Controller
{
    public function index()
    {
        // 'with('user')' akan memanggil relasi yang sudah kamu buat di Model tadi
        $dataBerkas = Antrian::whereNotNull('dokumen')
                             ->with('user') 
                             ->paginate(7);

        return view('admin.verifikasi-berkas', compact('dataBerkas'));
    }

    public function updateStatus(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->status = $request->status;
        $antrian->save();

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui!');
    }
}