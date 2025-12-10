<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama tanpa melanggar foreign key
        Product::query()->delete();

        $brands = [
            'Rolex'   => Brand::where('name', 'Rolex')->first()->id,
            'Omega'   => Brand::where('name', 'Omega')->first()->id,
            'Seiko'   => Brand::where('name', 'Seiko')->first()->id,
            'Casio'   => Brand::where('name', 'Casio')->first()->id,
            'Citizen' => Brand::where('name', 'Citizen')->first()->id,
        ];

        forEach ($brands as $brandName => $brandId) {
            for ($i = 1; $i <= 10; $i++) {
                Product::create([
                    'brand_id'   => $brandId,
                    'name'       => "$brandName Watch Model $i",
                    'model'      => "$brandName-$i",
                    'type'       => 'analog',
                    'price'      => 1,
                    'description'=> "$brandName Watch Model $i adalah jam tangan analog berkualitas tinggi.",
                    'image_url'  => "https://example.com/images/{$brandName}_{$i}.jpg",
                    'stock'      => rand(5, 50),
                ]);
            }
        }
    }
}
