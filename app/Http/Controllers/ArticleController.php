<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category; 
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // 1. Ambil data Berita Utama (Hero)
        $hero = Article::where('is_published', true)->latest()->first();

        // 2. Ambil artikel lainnya (kecuali hero), paginate 6 per halaman
        $articles = Article::where('is_published', true)
                        ->where('id', '!=', $hero->id ?? 0) // Hindari duplikasi dengan Hero
                        ->latest()
                        ->paginate(6);

        // 3. AMBIL DATA KATEGORI DARI DATABASE
        $categories = Category::all(); 

        // 4. Kirim semua variabel ke View
        return view('home', [
            'hero' => $hero,
            'articles' => $articles,
            'categories' => $categories 
        ]);
    }

    public function show($slug)
    {
        
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Update views count
        $article->increment('views');

        return view('show', [
            'article' => $article,
            'categories' => Category::all() // Kirim juga kategori ke halaman detail biar navbar tetap muncul
        ]);
    }
}