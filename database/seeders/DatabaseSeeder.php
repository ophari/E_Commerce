<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]); 

        User::factory(10)->create();
        Cart::factory(3)->has(CartItem::factory()->count(3))->create();
        Order::factory(5)->has(OrderItem::factory()->count(3))->create();
        Review::factory(15)->create();
    }
}