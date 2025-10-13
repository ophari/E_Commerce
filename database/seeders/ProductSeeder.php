<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Seiko Automatic',
                'brand' => 'Seiko',
                'description' => 'Jam tangan elegan dengan mesin otomatis.',
                'price' => 2500000,
                'stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
            ],
            [
                'name' => 'Casio G-Shock',
                'brand' => 'Casio',
                'description' => 'Jam tangguh untuk aktivitas outdoor.',
                'price' => 1800000,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
            ],
            [
                'name' => 'Citizen Eco-Drive',
                'brand' => 'Citizen',
                'description' => 'Jam bertenaga cahaya dengan desain klasik.',
                'price' => 3100000,
                'stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1504198453319-5ce911bafcde',
            ],
        ]);
    }
}