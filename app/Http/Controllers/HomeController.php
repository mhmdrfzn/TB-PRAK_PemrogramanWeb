<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function allNews()
    {
        return view('all-news', [
            'title' => 'Semua Berita',
            // Ambil semua artikel, urutkan terbaru, batasi 12 per halaman
            'articles' => \App\Models\Article::latest()->paginate(12),
            // Tetap kirim kategori untuk navbar
            'categories' => \App\Models\Category::all() 
        ]);
    }
}
