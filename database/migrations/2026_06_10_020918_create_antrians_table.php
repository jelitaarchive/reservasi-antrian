<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('jenis_layanan');
            $table->string('kategori_layanan');
            $table->string('waktu_layanan'); 
            $table->string('nomor_antrian'); 
            $table->date('tanggal_antrian'); 
            $table->string('status')->default('menunggu'); // Kita pastikan ada kolom status!
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};