<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id']; // Semua kolom boleh diisi kecuali ID

    // Relasi: Satu User punya BANYAK Artikel
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    protected $fillable = [
        'name',
        'username', // <--- Pastikan ini ada!
        'email',
        'password',
        'role', // (Opsional, jika Anda pakai role)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
