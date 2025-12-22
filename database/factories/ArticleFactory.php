<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(mt_rand(4, 8)),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(),
            // Membuat 5-10 paragraf lalu dibungkus tag <p>
            'body' => collect($this->faker->paragraphs(mt_rand(5, 10)))
                        ->map(fn($p) => "<p>$p</p>")
                        ->implode(''),
            'user_id' => mt_rand(1, 3), // Asumsi kita punya 3 user
            'category_id' => mt_rand(1, 5), // Asumsi kita punya 5 kategori
            'views' => mt_rand(10, 1000), // Random views untuk tes fitur "Populer"
            'is_published' => true,
        ];
    }
}
