<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Amankan data lama: Ubah semua data yang NULL menjadi 'selesai' atau 'batal' terlebih dahulu
        DB::table('queue_histories')->whereNull('status')->update(['status' => 'selesai']);

        Schema::table('queue_histories', function (Blueprint $table) {
            // 2. Ubah tipe data menjadi ENUM, NOT NULL, dan beri default 'selesai'
            $table->enum('status', ['selesai', 'batal'])->default('selesai')->change();
        });
    }

    public function down(): void
    {
        Schema::table('queue_histories', function (Blueprint $table) {
            // Mengembalikan ke varchar jika migration di-rollback
            $table->string('status')->nullable()->change();
        });
    }
};