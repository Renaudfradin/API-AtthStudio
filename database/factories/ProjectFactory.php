<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'slug' => fake()->slug(),
            'content' => fake()->text(),
            'active' => fake()->boolean(),
            'image' => 'details/01JXDF4Q34FYMVHC4R8ZFRAN1X.png',
        ];
    }
}
