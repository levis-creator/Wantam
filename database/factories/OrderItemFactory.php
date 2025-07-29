<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = ProductVariant::where('product_id', $product->id)->inRandomOrder()->first()
            ?? ProductVariant::factory()->create(['product_id' => $product->id]);

        $price = $variant->price ?? $product->price;

        return [
            'id' => Str::uuid()->toString(),
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'price' => $price,
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
