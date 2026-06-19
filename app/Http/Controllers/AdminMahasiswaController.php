<?php

namespace App\Http\Controllers;

use App\Models\User; // Memanggil model User yang sudah kamu punya
use Illuminate\Http\Request;

class AdminMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil user yang memiliki role 'mahasiswa'
        $query = User::where('role', 'mahasiswa'); 

        // Jalankan pencarian dinamis (Search Bar)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%"); // Disesuaikan jadi 'phone'
            });
        }

        // Ambil data dengan pagination 7 baris per halaman
        $daftarMahasiswa = $query->paginate(7)->withQueryString();

        return view('admin.kelola-mahasiswa', compact('daftarMahasiswa', 'search'));
    }

    public function destroy($id)
    {
        // Menghapus mahasiswa berdasarkan ID menggunakan Eloquent ORM
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}