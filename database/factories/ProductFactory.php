<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'category' => $this->faker->randomElement(['Soins du visage', 'Maquillage', 'Parfums', 'Accessoires']),
            'image' => $this->faker->imageUrl(640, 480, 'cosmetics'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
