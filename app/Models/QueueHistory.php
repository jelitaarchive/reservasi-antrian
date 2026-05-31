<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueHistory extends Model
{
    use HasFactory;

    // Tentukan nama tabel di database kamu (misal: queue_histories atau antrean_riwayat)
    protected $table = 'queue_histories'; 
}