<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
        public function index(Request $request)
        {
            $search = $request->input('search', '');

            // Pastikan setiap item memiliki key 'nama' dan 'deskripsi'
            $layanans = [
                ['nama' => 'Pengajuan Skripsi/TA', 'deskripsi' => 'Proses administrasi awal pendaftaran tugas akhir...'],
                ['nama' => 'Pendaftaran Magang dan PKL', 'deskripsi' => 'Pengurusan surat pengantar resmi...'],
                ['nama' => 'Surat Keterangan Aktif Kuliah', 'deskripsi' => 'Layanan penerbitan surat keterangan resmi...'],
                ['nama' => 'Penggantian KTM', 'deskripsi' => 'Layanan untuk penggantian kartu mahasiswa...'],
            ];

            return view('administrasi', compact('layanans', 'search'));
        }
}