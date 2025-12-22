<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Manual (Supaya Anda bisa Login nanti)
        User::create([
            'name' => 'Admin Kompas',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // 2. Buat User Random (Penulis lain)
        User::factory(3)->create();

        // 3. Buat Kategori (Misal: Bola, Tekno, Hype, News, Otomotif)
        Category::create(['name' => 'Web Programming', 'slug' => 'web-programming']);
        Category::create(['name' => 'Personal', 'slug' => 'personal']);
        Category::factory(3)->create(); // Tambah 3 random lagi

        // 4. Buat Tags
        Tag::factory(10)->create();

        // 5. Buat Artikel & Relasikan dengan Tags
        // Kita buat 20 artikel berita
        $articles = Article::factory(20)->create();
        
        // Ambil semua data tags
        $tags = Tag::all();

        // Looping setiap artikel untuk ditempelkan Tag secara acak
        $articles->each(function ($article) use ($tags) {
            // Attach 1 sampai 3 tag secara acak ke setiap artikel
            $article->tags()->attach(
                $tags->random(mt_rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
