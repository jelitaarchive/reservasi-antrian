<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprinted) {
            // Menambahkan kolom whatsapp setelah kolom email
            $blueprinted->string('whatsapp')->nullable()->after('email'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprinted) {
            $blueprinted->dropColumn('whatsapp');
        });
    }
};