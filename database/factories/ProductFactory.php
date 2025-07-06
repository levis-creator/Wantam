<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        $originalPrice = $this->faker->randomFloat(2, 100, 1000);
        $discount = $this->faker->optional(0.7)->randomFloat(2, 5, 50); // 70% chance to have a discount
        $price = $discount ? round($originalPrice * (1 - $discount / 100), 2) : $originalPrice;

        return [
            'id' => Str::uuid()->toString(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'main_image' => $this->faker->imageUrl(640, 640, 'products', true),
            'images' => [
                $this->faker->imageUrl(640, 640, 'products', true),
                $this->faker->imageUrl(640, 640, 'products', true),
            ],
            'description' => $this->faker->paragraph(5),

            'original_price' => $originalPrice,
            'discount' => $discount,
            'price' => $price,

            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(30),
            'rating' => $this->faker->optional()->randomFloat(1, 1, 5),
        ];
    }
}
