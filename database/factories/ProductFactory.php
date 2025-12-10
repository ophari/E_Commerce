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
        $brands = ['Seiko', 'Casio', 'Citizen', 'Rolex', 'Omega'];
        $brand = fake()->randomElement($brands);
        
        $images = [
            'watch-hero.png',
            'pmo1.jpg',
            'pmo2.jpg',
            '20251117141556.png',
            '20251118150726.jpg',
            '20251118150931.jpg',
            '20251118151319.jpg',
            '20251118151341.jpg',
            '20251123033204.jpeg',
            'promo1.png',
        ];

        // Determine price range based on brand (simplified version of Seeder logic)
        $priceMin = 500000;
        $priceMax = 5000000;
        if (in_array($brand, ['Rolex', 'Omega'])) {
            $priceMin = 50000000;
            $priceMax = 500000000;
        } elseif (in_array($brand, ['Seiko', 'Citizen'])) {
            $priceMin = 1500000;
            $priceMax = 15000000;
        }

        $price = round(fake()->numberBetween($priceMin, $priceMax) / 10000) * 10000;

        return [
            'brand_id' => Brand::firstOrCreate(['name' => $brand]),
            'name' => $brand . ' ' . fake()->word(),
            'model' => strtoupper(fake()->bothify('??-####')),
            'type' => fake()->randomElement(['analog', 'digital', 'smartwatch']),
            'price' => $price,
            'description' => fake()->paragraph(),
            'image_url' => fake()->randomElement($images),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}