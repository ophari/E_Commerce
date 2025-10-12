<?php

namespace Database\Factories;

use App\Models\Brand;
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
            'brand_id' => Brand::factory(),
            'name' => fake()->words(3, true),
            'model' => fake()->word(),
            'type' => fake()->randomElement(['analog', 'digital', 'smartwatch']),
            'price' => fake()->randomFloat(2, 10, 1000),
            'description' => fake()->paragraph(),
            'image_url' => fake()->imageUrl(),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}