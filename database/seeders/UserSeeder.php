<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //users
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'sistem@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'sistem'
        ]);

        User::create([
            'name' => 'Administrasi',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'administrasi'
        ]);

        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'mahasiswa'
        ]);
    }
}
