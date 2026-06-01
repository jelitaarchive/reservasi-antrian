<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('queue_histories', function (Blueprint $blueprint) {
            // Menambahkan foreign key user_id setelah kolom id utama
            $blueprint->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('queue_histories', function (Blueprint $blueprint) {
            $blueprint->dropForeign(['user_id']);
            $blueprint->dropColumn('user_id');
        });
    }
};