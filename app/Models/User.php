<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'phone',
        'password',
        'role',
        'photo',
        'last_login_at', // <-- 1. Daftarkan kolom baru di sini agar bisa di-update otomatis
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime', // <-- 2. Ubah tipe datanya ke datetime Carbon agar mudah diformat di Blade
        ];
    }

    /**
     * 3. Fungsi otomatis untuk menangkap event login user/admin
     */
    protected static function booted()
    {
        static::class;
        app('events')->listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            $event->user->update([
                'last_login_at' => now(),
            ]);
        });
    }
}