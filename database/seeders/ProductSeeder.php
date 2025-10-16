<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get brand IDs
        $seiko = \App\Models\Brand::where('name', 'Seiko')->first();
        $casio = \App\Models\Brand::where('name', 'Casio')->first();
        $citizen = \App\Models\Brand::where('name', 'Citizen')->first();

        Product::insert([
            [
                'brand_id' => $seiko->id,
                'name' => 'Seiko Automatic',
                'model' => '5 Automatic',
                'type' => 'analog',
                'description' => 'Jam tangan elegan dengan mesin otomatis.',
                'price' => 2500000,
                'stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
            ],
            [
                'brand_id' => $casio->id,
                'name' => 'Casio G-Shock',
                'model' => 'GA-2100',
                'type' => 'digital',
                'description' => 'Jam tangguh untuk aktivitas outdoor.',
                'price' => 1800000,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
            ],
            [
                'brand_id' => $citizen->id,
                'name' => 'Citizen Eco-Drive',
                'model' => 'BM8180-03E',
                'type' => 'analog',
                'description' => 'Jam bertenaga cahaya dengan desain klasik.',
                'price' => 3100000,
                'stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1504198453319-5ce911bafcde',
            ],
        ]);
    }
}