<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Food', 'Snacks', 'Drinks', 'Healthy']),
            'price' => fake()->randomFloat(2, 1, 10),
            'rating' => fake()->randomFloat(1, 3, 5),
            'image' => 'https://placehold.co/300x200',
            'is_top_sale' => fake()->boolean(),
        ];
    }
}
