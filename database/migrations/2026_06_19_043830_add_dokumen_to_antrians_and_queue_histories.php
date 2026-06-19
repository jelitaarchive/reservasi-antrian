<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Menambahkan kolom dokumen setelah kolom status (nullable artinya boleh kosong)
            $table->string('dokumen')->nullable()->after('status');
        });

        Schema::table('queue_histories', function (Blueprint $table) {
            // Menambahkan kolom dokumen dan status di tabel riwayat agar sinkronisasi badge lebih akurat
            $table->string('status')->nullable()->after('description');
            $table->string('dokumen')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropColumn('dokumen');
        });

        Schema::table('queue_histories', function (Blueprint $table) {
            $table->dropColumn(['status', 'dokumen']);
        });
    }
};