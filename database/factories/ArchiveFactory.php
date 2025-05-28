<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArchiveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'slug' => fake()->slug(),
            'content' => fake()->text(),
            'active' => fake()->boolean(),
            'image' => 'https://renaud-portfolio.vercel.app/assets/loup.c2a97082.svg',
        ];
    }
}
