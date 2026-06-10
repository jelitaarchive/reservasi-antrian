<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = [
        'user_id', 
        'jenis_layanan', 
        'kode_antrian', 
        'waktu_layanan', 
        'status'
    ];
}