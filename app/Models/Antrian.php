<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'metode_pembayaran',
        'waktu_layanan',
        'nomor_antrian',
        'tanggal_antrian',
        'status',
        'dokumen',
        'bukti_transfer',
    ];

    // Relasi ke User (berdasarkan email)
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function scopeMenunggu($query) {
    return $query->where('status', 'Menunggu');
    }

    public function scopeDiproses($query) {
        return $query->where('status', 'Diproses');
    }
}