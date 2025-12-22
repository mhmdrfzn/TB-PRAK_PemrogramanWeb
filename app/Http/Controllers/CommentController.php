<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'body' => 'required|min:3|max:500' // Minimal 3 huruf, max 500
        ]);

        // Tambahkan user_id otomatis dari yang sedang login
        $validated['user_id'] = Auth::id();

        // Simpan ke database
        Comment::create($validated);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }
    
    // Fitur Hapus Komentar (Hanya pemilik atau Admin yg bisa hapus - Opsional)
    public function destroy(Comment $comment)
    {
        // Pastikan yang hapus adalah pemilik komentar
        if($comment->user_id !== Auth::id()) {
            abort(403);
        }
        
        $comment->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}