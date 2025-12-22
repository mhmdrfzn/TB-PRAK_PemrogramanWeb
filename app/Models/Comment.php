<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Komentar milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Komentar milik Artikel
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}