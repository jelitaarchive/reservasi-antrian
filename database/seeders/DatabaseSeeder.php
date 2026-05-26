<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin Adminisitrasi
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password123'),
        ]);

        // Membuat akun Mahasiswa Dummy
        User::factory()->create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@mahasiswa.ac.id',
            'password' => Hash::make('password123'),
        ]);
    }
}