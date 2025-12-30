<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Inisialisasi Faker Indonesia
        $faker = Faker::create('id_ID');

        // -------------------------------------------
        // BAGIAN 1: USER / PENULIS
        // -------------------------------------------
        
        // A. Admin Utama (Akun Anda)
        User::create([
            'name' => 'Admin Kompas',
            'username' => 'admin2',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // B. Penulis Lain (Nama Indonesia)
        // Kita buat 5 penulis tambahan
        $authors = [];
        for ($i = 0; $i < 5; $i++) {
            $authors[] = User::create([
                'name' => $faker->name, // Contoh: Budi Santoso, Siti Aminah
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->email,
                'password' => bcrypt('password'),
                'role' => 'user', // Anggap saja role default author/user biasa
            ]);
        }

        // -------------------------------------------
        // BAGIAN 2: KATEGORI (Topik Lokal)
        // -------------------------------------------
        $kategoriList = ['Politik', 'Olahraga', 'Teknologi', 'Selebriti', 'Otomotif', 'Kesehatan'];
        $categories = collect();

        foreach ($kategoriList as $cat) {
            $categories->push(Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat)
            ]));
        }

        // -------------------------------------------
        // BAGIAN 3: TAGS (Isu Terkini)
        // -------------------------------------------
        $tagList = ['Pilkada 2024', 'Timnas Indonesia', 'Viral Medsos', 'Startup', 'Korupsi', 'Mobil Listrik', 'Tips Sehat', 'Wisata Kuliner'];
        $tags = collect();

        foreach ($tagList as $tagName) {
            $tags->push(Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName)
            ]));
        }

        // -------------------------------------------
        // BAGIAN 4: ARTIKEL (Judul Bahasa Indonesia)
        // -------------------------------------------
        
        // Kita buat array judul berita dummy yang terlihat nyata
        $indoTitles = [
            "Harga Cabai Meroket Menjelang Hari Raya, Ibu-Ibu Menjerit",
            "Timnas Indonesia Siap Hadapi Jepang di Kualifikasi Piala Dunia",
            "Bocoran Fitur Baru iPhone 16 yang Bikin Penasaran",
            "Viral! Aksi Heroik Ojol Selamatkan Kucing di Atas Pohon",
            "Resep Nasi Goreng Kampung Enak dan Praktis untuk Sarapan",
            "Daftar Mobil Listrik Murah yang Masuk Indonesia Tahun Ini",
            "Tips Menjaga Kesehatan Mata bagi Pekerja Depan Layar",
            "Skandal Artis Ibukota Kembali Menghebohkan Publik",
            "Review Laptop Gaming Murah: Performa Gahar Harga Pelajar",
            "Wisata Bali Semakin Ramai Dikunjungi Turis Asing",
            "Mengenal AI Generative dan Dampaknya Bagi Pekerjaan Masa Depan",
            "Kronologi Kecelakaan Beruntun di Tol Cipularang",
            "Debat Capres Semakin Panas, Ini Poin Pentingnya",
            "Cara Merawat Motor Matic Agar Awet dan Irit Bensin",
            "Festival Musik Jakarta Ricuh, Penonton Minta Refund"
        ];

        foreach ($indoTitles as $title) {
            // Pilih kategori & user secara acak
            $randomCategory = $categories->random();
            $randomUser = $authors[array_rand($authors)];

            // Buat Artikel
            $article = Article::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(5),
                'excerpt' => 'Ini adalah ringkasan berita tentang ' . $title . ' yang sedang hangat dibicarakan masyarakat.',
                'body' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>', // Isi paragraf random tapi panjang
                'image' => null, // Biarkan kosong atau null
                'category_id' => $randomCategory->id,
                'user_id' => $randomUser->id,
                'is_published' => $faker->boolean(100), // 100% kemungkinan tayang
                'views' => $faker->numberBetween(0, 100000),
            ]);

            // Tempelkan Tag Acak (1 s/d 3 tag per artikel)
            $article->tags()->attach(
                $tags->random(mt_rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}