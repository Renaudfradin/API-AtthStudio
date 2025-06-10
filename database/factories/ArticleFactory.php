<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'slug' => fake()->slug(),
            'content' => fake()->text(),
            'active' => fake()->boolean(),
            'image' => 'details/01JXDF4Q34FYMVHC4R8ZFRAN1X.png',
            'category_id' => Category::factory(),
            'time_read' => fake()->randomDigit(),
        ];
    }
}
