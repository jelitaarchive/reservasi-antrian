<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrians';
    protected $fillable = [
<<<<<<< HEAD
        'nama',
        'nim',
        'email',
        'whatsapp',
        'jenis_layanan',
        'kategori_layanan',
        'waktu_layanan',
        'nomor_antrian',
        'tanggal_antrian',
        'status',
        'dokumen',
    ];
=======

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
>>>>>>> bfd8538b2193fc39ce995d9ff3121e16850c2355

    // Relasi ke User (opsional, untuk dipanggil di blade jika dibutuhkan)
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}