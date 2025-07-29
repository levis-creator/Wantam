<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are some orders and products
        Order::factory()->count(10)->create()->each(function ($order) {
            // Add 1 to 5 items per order
            $itemsCount = rand(1, 5);

            for ($i = 0; $i < $itemsCount; $i++) {
                $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
                $variant = ProductVariant::where('product_id', $product->id)->inRandomOrder()->first()
                    ?? ProductVariant::factory()->create(['product_id' => $product->id]);

                $price = $variant->price ?? $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant->id,
                    'price' => $price,
                    'quantity' => rand(1, 3),
                ]);
            }
        });
    }
}
