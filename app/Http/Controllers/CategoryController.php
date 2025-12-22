<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Tampilkan daftar kategori
    public function index()
    {
        return view('dashboard.categories.index', [
            'categories' => Category::withCount('articles')->get() // Hitung jumlah artikel per kategori
        ]);
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:50|unique:categories,name,'.$category->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return back()->with('success', 'Nama kategori berhasil diubah!');
    }

    // Hapus kategori
    public function destroy($id)
    {
        // Opsional: Cek dulu apakah kategori ini dipakai artikel?
        // Jika dipakai, jangan dihapus agar data artikel tidak rusak.
        $category = Category::findOrFail($id);
        
        if ($category->articles()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada artikel yang menggunakan kategori ini.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function show($slug)
    {
        // 1. Cari kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // 2. Ambil artikel yang terkait dengan kategori ini (Pagination 9 per halaman)
        $articles = $category->articles()
                            ->where('is_published', true)
                            ->latest()
                            ->paginate(9);

        // 3. Ambil semua kategori untuk Navbar
        $categories = Category::all();

        // 4. Tampilkan view khusus kategori
        return view('category', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}