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
        Schema::create('queue_histories', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Untuk judul antrean (ex: Pembayaran UKT)
            $table->date('date');    // Untuk tanggal antrean
            $table->time('start_time'); // Jam mulai
            $table->time('end_time');   // Jam selesai
            $table->text('description')->nullable(); // Deskripsi lorem ipsum
            $table->timestamps();    // Otomatis membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_histories');
    }
};
