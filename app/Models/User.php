<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject; 

class User extends Authenticatable implements JWTSubject // Implementasikan JWTSubject
{
    use HasApiTokens, Notifiable;

    // Konstanta untuk role
    const ROLE_ADMIN = 'admin';
    const ROLE_PELANGGAN = 'pelanggan';

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Metode yang diperlukan oleh JWTSubject
    public function getJWTIdentifier()
    {
        // Mengembalikan identifier unik untuk user, biasanya id pengguna
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Mengembalikan klaim khusus yang ingin Anda tambahkan pada token (optional)
        return [];
    }
 

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Cek apakah user adalah pelanggan
    public function isPelanggan()
    {
        return $this->role === self::ROLE_PELANGGAN;
    }
}