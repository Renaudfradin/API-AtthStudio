<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        $images = [
            'documents/01JYK74EXSGRX7A9XQWYN27BCG.jpg',
            'documents/01JYK755SASWEGBN32D86QVHNA.png',
        ];

        return [
            'image' => $images[array_rand($images)],
            'documentable_id' => 1,
            'documentable_type' => 'App\\Models\\Article',
        ];
    }
}
