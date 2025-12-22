<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

// Tambahkan middleware('auth') agar tamu tidak bisa masuk
Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/read/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/tags/{slug}', [\App\Http\Controllers\TagController::class, 'show'])->name('tags.show');

Auth::routes();




Route::middleware(['auth'])->group(function () {
    
    // Halaman Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::post('/dashboard/create', [DashboardController::class, 'store'])->name('dashboard.store');
    // ... route dashboard.create dan store ...

    Route::get('/dashboard/edit/{id}', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/edit/{id}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');

    Route::resource('/dashboard/categories', \App\Http\Controllers\CategoryController::class)->except(['show', 'create', 'edit']);

    Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    Route::resource('/dashboard/tags', \App\Http\Controllers\TagController::class)->only(['index', 'store', 'destroy']);
    
    // Nanti kita tambah route create, store, edit, delete di sini
});