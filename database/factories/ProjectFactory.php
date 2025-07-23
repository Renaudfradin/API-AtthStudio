<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'title_home' => fake()->word(),
            'slug' => fake()->slug(),
            'content' => fake()->text(),
            'active' => fake()->boolean(),
        ];
    }
}
