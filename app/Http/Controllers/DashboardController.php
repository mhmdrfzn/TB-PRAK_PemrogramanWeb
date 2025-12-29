<?php

namespace App\Http\Controllers;

// --- TAMBAHKAN BARIS INI ---
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// ---------------------------

class DashboardController extends Controller
{
    
    public function index()
    {
        $userId = Auth::id();

        // Ambil data artikel
        $articles = Article::where('user_id', $userId)
                        ->with('category') // Eager load kategori biar cepat
                        ->latest()
                        ->paginate(10);

        // Hitung Statistik Sederhana
        $stats = [
            'total_articles' => Article::where('user_id', $userId)->count(),
            'total_views'    => Article::where('user_id', $userId)->sum('views'),
            'published'      => Article::where('user_id', $userId)->where('is_published', 1)->count(),
            'draft'          => Article::where('user_id', $userId)->where('is_published', 0)->count(),
        ];

        return view('dashboard.index', [
            'articles' => $articles,
            'stats' => $stats
        ]);
    }

    public function create()
    {
        return view('dashboard.create', [
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    // 2. Proses Simpan Berita
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|file|max:2048',
            'tags' => 'nullable|array', 
        ]);

        // Tambahkan data manual yang tidak ada di form
        $validated['user_id'] = Auth::id();
        $validated['excerpt'] = Str::limit(strip_tags($request->body), 100);
        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5); // Slug unik
        
        // Cek apakah user upload gambar?
        if($request->file('image')) {
            $validated['image'] = $request->file('image')->store('article-images', 'public');
        }

        // Simpan ke database
        $article = Article::create($validated);

        // Simpan Tags (jika ada)
        if ($request->tags) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                // Cari Tag berdasarkan nama, kalau gak ada -> Buat Baru
                $tag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
            // Hubungkan ID tags ke artikel
            $article->tags()->attach($tagIds);
        }

        return redirect()->route('dashboard')->with('success', 'Berita berhasil dibuat!');
    }

    public function edit($id)
    {
        // Cari artikel berdasarkan ID, kalau tidak ketemu tampilkan 404
        $article = Article::findOrFail($id);
        
        // Pastikan yang edit adalah pemilik artikelnya (Security)
        if ($article->user_id != Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit artikel ini.');
        }

        return view('dashboard.edit', [
            'article' => $article,
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    // 4. Proses Update ke Database
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Security check lagi
        if ($article->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|file|max:2048',
            'is_published' => 'required|boolean', // Validasi status tayang
        ]);

        // Update Slug jika judul berubah
        if($request->title != $article->title) {
            $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        // Cek gambar baru
        if($request->file('image')) {
            $validated['image'] = $request->file('image')->store('article-images', 'public');
        }

        // Simpan perubahan
        $article->update($validated);

        // Sync Tags (hapus lama, masukkan baru)
        $tagIds = [];
        if ($request->tags) {
            foreach ($request->tags as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
        }
        // Gunakan SYNC agar tag lama terhapus dan diganti yang baru
        $article->tags()->sync($tagIds);

        return redirect()->route('dashboard')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Security Check: Pastikan yang menghapus adalah pemiliknya
        if ($article->user_id != Auth::id()) {
            abort(403);
        }

        
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        // Hapus data dari database
        $article->delete();

        return redirect()->route('dashboard')->with('success', 'Artikel berhasil dihapus!');
    }
}