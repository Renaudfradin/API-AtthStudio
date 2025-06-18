<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Psychologie cognitive & UX design : Quand le cerveau devient votre meilleur allié',
            'slug' => 'psychologie-cognitive-ux-design-quand-le-cerveau-devient-votre-meilleur-allie',
            'content' => fake()->text(),
            'active' => fake()->boolean(),
            'image' => 'details/01JY1GGA9S22CGFSSYQRMQ7PZ4.jpg',
            'category_id' => Category::factory(),
            'time_read' => fake()->randomDigit(),
        ];
    }
}
