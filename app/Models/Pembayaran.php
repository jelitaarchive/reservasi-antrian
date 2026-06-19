<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'user_id',
        'jenis_pembayaran',
        'metode_pembayaran',
        'status',
        'nomor_antrian',
        'bukti_transfer'
    ];
}