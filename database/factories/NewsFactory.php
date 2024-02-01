<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{

    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'language' => 'pt', // Substitua 'en' e 'pt' pelos seus idiomas
            'category_id' => fake()->numberBetween(1, 3), // Substitua 1 e 5 pelo seu range de categorias
            'author_id' => 1, // Substitua 1 e 10 pelo seu range de autores
            'image' => fake()->imageUrl(),
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'content' => fake()->paragraph,
            'meta_title' => fake()->sentence,
            'meta_description' => fake()->paragraph,
            'is_breaking_news' => fake()->boolean,
            'show_at_slider' => fake()->boolean,
            'show_at_popular' => fake()->boolean,
            'status' => fake()->boolean,
            'is_approved' => 1,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (News $news) {
            $item = Tag::firstOrCreate([
                'name' => fake()->word(),
                'language' => 'pt'
            ]);

            $news->tags()->attach($item->id);
        });
    }
}
