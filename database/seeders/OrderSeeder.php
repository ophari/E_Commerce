<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Create orders for up to 10 random users
        foreach ($users->random(min(10, $users->count())) as $user) {
            $order = Order::factory()->create([
                'user_id' => $user->id,
            ]);

            // Add 1-4 random products to the order
            foreach ($products->random(min(4, $products->count())) as $product) {
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 2),
                    'price' => $product->price, // Use actual product price
                ]);
            }
        }
    }
}