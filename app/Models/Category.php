<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Satu Category punya BANYAK Artikel
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
