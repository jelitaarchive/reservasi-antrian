<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminKelolaController extends Controller
{
    public function index()
    {
        // Mengambil data admin dengan pagination 7 data per halaman
        $dataAdmin = User::where('role', 'admin')->latest()->paginate(7);
        return view('admin.kelola-admin', compact('dataAdmin'));
    }

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
            'password' => bcrypt($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->back()->with('success', 'Akun admin baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        if ($admin->id === auth()->id()) {
            return redirect()->back()->with('error', 'Gagal! Anda tidak bisa menghapus akun sendiri.');
        }
        $admin->delete();
        return redirect()->back()->with('success', 'Akun admin berhasil dihapus!');
    }
}