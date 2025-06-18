<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArchiveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Labubu',
            'slug' => 'labubu',
            'content' => 'Askip Coffee est une marque jeune et décomplexée qui réinvente la pause café avec audace et authenticité. Inspirée par la culture urbaine et les conversations spontanées, elle propose une expérience sensorielle vivante, ancrée dans le partage et la curiosité. Chaque tasse devient un prétexte à l’échange, une histoire à raconter. Askip Coffee casse les codes traditionnels du café en misant sur le style, la sincérité et une touche d’humour. Plus qu’une boisson : une attitude.',
            'active' => fake()->boolean(),
            'image' => 'details/01JY1G2PSKMP5D98XDBF6B32CV.png',
        ];
    }
}
