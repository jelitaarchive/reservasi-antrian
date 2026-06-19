<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    // Ini kunci utamanya! Semua kolom wajib didaftarkan di sini agar diizinkan masuk ke DB
    protected $fillable = [

'nama',

'nim',

'email',

'whatsapp',

'jenis_layanan',

'kategori_layanan',

'metode_pembayaran',

'waktu_layanan',

'nomor_antrian',

'tanggal_antrian',

'status',

'bukti_transfer'

];

    // Relasi ke User (opsional, untuk dipanggil di blade jika dibutuhkan)
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}