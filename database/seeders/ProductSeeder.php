<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand; // Make sure Brand model is imported for the factory

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Clear existing products to avoid duplicates when re-running the seeder
        Product::truncate();
        // Brand::truncate(); // Don't truncate brands, let BrandSeeder handle them or use existing ones

        // Re-enable foreign key checks
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Available images in public/image
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

        $brands = [
            'Seiko' => ['models' => ['Prospex', 'Presage', '5 Sports', 'Astron', 'King Seiko'], 'price_min' => 2000000, 'price_max' => 15000000],
            'Casio' => ['models' => ['G-Shock', 'Edifice', 'Pro Trek', 'Classic', 'Vintage'], 'price_min' => 500000, 'price_max' => 5000000],
            'Citizen' => ['models' => ['Promaster', 'Eco-Drive One', 'Series 8', 'Attesa', 'Tsuyosa'], 'price_min' => 1500000, 'price_max' => 8000000],
            'Rolex' => ['models' => ['Submariner', 'Daytona', 'Datejust', 'Oyster Perpetual', 'GMT-Master II'], 'price_min' => 100000000, 'price_max' => 500000000],
            'Omega' => ['models' => ['Speedmaster', 'Seamaster', 'Constellation', 'De Ville', 'Aqua Terra'], 'price_min' => 50000000, 'price_max' => 150000000],
        ];

        $imageIndex = 0;

        foreach ($brands as $brandName => $data) {
            // Find existing brand or create if missing (fallback)
            $brand = Brand::firstOrCreate(['name' => $brandName], ['description' => fake()->paragraph()]);

            // Create 4 products per brand
            foreach (array_slice($data['models'], 0, 4) as $modelName) {
                // Generate a random price within the brand's range
                $randomPrice = fake()->numberBetween($data['price_min'], $data['price_max']);
                // Round to nearest thousand for cleaner look (e.g. 2500000 instead of 2543212)
                $cleanPrice = round($randomPrice / 10000) * 10000; 

                Product::create([
                    'brand_id' => $brand->id,
                    'name' => "$brandName $modelName",
                    'model' => strtoupper(fake()->bothify('??-####')), // Random model number like SK-1234
                    'type' => fake()->randomElement(['analog', 'digital', 'smartwatch']),
                    'price' => $cleanPrice, 
                    'description' => fake()->paragraph(),
                    'image_url' => $images[$imageIndex % count($images)],
                    'stock' => fake()->numberBetween(5, 50),
                ]);
                
                $imageIndex++;
            }
        }
    }
}