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

        // Re-enable foreign key checks
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Create some brands if they don't exist, as product factory depends on them
        if (Brand::count() === 0) {
            Brand::factory()->create(['name' => 'Seiko']);
            Brand::factory()->create(['name' => 'Casio']);
            Brand::factory()->create(['name' => 'Citizen']);
            Brand::factory()->create(['name' => 'Rolex']); // Adding a few more for variety
            Brand::factory()->create(['name' => 'Omega']);
        }
        
        // Use the ProductFactory to create 20 new products
        // The factory already handles brand_id, name, model, type, price, description, image_url, and stock.
        Product::factory()->count(20)->create();
    }
}