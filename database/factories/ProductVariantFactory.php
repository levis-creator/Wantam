<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),

            'product_id' => Product::factory(),
            'size_id' => Size::factory(),
            'color_id' => Color::factory(),

            'sku' => strtoupper('SKU-' . $this->faker->unique()->bothify('??###')),
            'price' => $this->faker->randomFloat(2, 50, 500), // Override if needed
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
