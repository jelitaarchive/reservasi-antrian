<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function store(Request $request)
    {
        // Gunakan 'berkas.*' untuk memvalidasi setiap file dalam array
        $request->validate([
            'berkas.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                // Proses masing-masing file
                $path = $file->store('uploads', 'public');
                // Simpan $path ke database sesuai kebutuhan
            }
            // Contoh di Controller
            foreach ($request->file('berkas') as $file) {
                $file->store('nama_folder', 'public');
            }
        }
    }
}
