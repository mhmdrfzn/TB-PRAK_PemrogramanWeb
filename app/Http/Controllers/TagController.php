<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        return view('dashboard.tags.index', [
            'tags' => Tag::withCount('articles')->latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:tags']);
        
        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Tag berhasil dibuat!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag dihapus!');
    }
    
    // Fitur Filter Artikel per Tag di Frontend (Public)
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $articles = $tag->articles()->latest()->paginate(9);
        
        return view('tag', [
            'tag' => $tag,
            'articles' => $articles,
            'categories' => \App\Models\Category::all() // Buat navbar
        ]);
    }
}