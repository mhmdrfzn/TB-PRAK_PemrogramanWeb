<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    // Opsional: Otomatis load relasi setiap kali artikel dipanggil (Eager Loading)
    // Supaya di view tidak perlu query ulang
    protected $with = ['category', 'user'];

    // Relasi: Artikel dimiliki oleh SATU Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Artikel ditulis oleh SATU User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Artikel memiliki BANYAK Tags
    // Perhatikan pakai 'belongsToMany' karena ada tabel pivot
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    // TIPS TAMBAHAN: Scope untuk pencarian (Biar Controller bersih)
    public function scopeFilter($query, array $filters)
    {
        // Kalau ada request 'search', cari di judul atau body
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('body', 'like', '%' . $search . '%');
        });

        // Kalau ada request 'category', cari artikel berdasarkan slug category
        $query->when($filters['category'] ?? false, function($query, $category) {
            return $query->whereHas('category', function($query) use ($category) {
                $query->where('slug', $category);
            });
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
