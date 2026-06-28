<?php

namespace App\Http\Controllers;

use App\Models\User; // Menggunakan model User utama proyekmu
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminKelolaController extends Controller
{
    /**
     * Tampilan Utama: Menampilkan daftar seluruh akun admin beserta info loginnya
     */
    public function index()
    {
        // Mengambil data user yang rolenya 'admin', diurutkan dari yang paling baru didaftarkan
        // Dan di-paginate 7 baris biar pas dengan layout tabel kamu
        $dataAdmin = User::where('role', 'admin')
                         ->latest()
                         ->paginate(7);

        return view('admin.kelola-admin', compact('dataAdmin'));
    }

    /**
     * Proses Menyimpan / Menambah Admin Baru ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password demi keamanan akun
            'role'     => 'admin', // Otomatis mengeset role sebagai admin
        ]);

        return redirect()->back()->with('success', 'Akun admin baru berhasil ditambahkan!');
    }

    /**
     * Proses Menghapus Akun Admin
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        
        // Proteksi tingkat tinggi: Cegah admin menghapus dirinya sendiri yang lagi login
        if ($admin->id === auth()->id()) {
            return redirect()->back()->with('error', 'Gagal! Anda tidak diizinkan menghapus akun Anda sendiri yang sedang aktif.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Akun admin berhasil dihapus dari sistem!');
    }
}