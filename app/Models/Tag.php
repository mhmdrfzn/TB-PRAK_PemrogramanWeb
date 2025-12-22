<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Satu Tag dimiliki oleh BANYAK Artikel
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}