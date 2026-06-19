<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrians';
    protected $fillable = [
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
    ];

    // Relasi ke User (opsional, untuk dipanggil di blade jika dibutuhkan)
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}