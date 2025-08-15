<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'id'                 => Str::uuid()->toString(),
            'user_id'            => User::factory(),
            'product_id'         => Product::factory(),
            'product_variant_id' => ProductVariant::factory(),
            'quantity'           => fake()->numberBetween(1, 5),
        ];
    }
}
