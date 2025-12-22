<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel Users (Author)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Foreign Key ke tabel Categories
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique(); // URL ramah SEO
            $table->string('image')->nullable(); // Thumbnail berita
            $table->text('excerpt'); // Cuplikan pendek untuk halaman depan
            $table->longText('body'); // Isi berita lengkap
            
            // Status: true (tayang), false (draft/belum tayang)
            $table->boolean('is_published')->default(false); 
            
            // Menghitung jumlah baca (Fitur "Terpopuler")
            $table->integer('views')->default(0); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
