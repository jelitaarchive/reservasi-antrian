<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
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
            $table->string('waktu_layanan'); // Untuk nyimpan text Shift A / B
            $table->string('nomor_antrian'); // Contoh: A-01, B-01
            $table->date('tanggal_antrian'); // Untuk reset urutan setiap berganti hari
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
