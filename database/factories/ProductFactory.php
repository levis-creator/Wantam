<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Generate product name and UUID
        $name = $this->faker->unique()->words(3, true);
        $uuid = Str::uuid()->toString();

        // Slug format: "product-name-xxxx"
        $slug = Str::slug($name) . '-' . substr($uuid, 0, 4);

        // Pricing
        $originalPrice = $this->faker->randomFloat(2, 100, 1000);
        $discount = $this->faker->optional(0.7)->randomFloat(2, 5, 50); // 70% chance of discount
        $price = $discount ? round($originalPrice * (1 - $discount / 100), 2) : $originalPrice;

        return [
            'id' => $uuid,

            // Foreign keys
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),

            // Basic details
            'name' => $name,
            'slug' => $slug,
            'main_image' => 'products/main/' . Str::random(10) . '.jpg',
            'images' => [
                'products/gallery/' . Str::random(12) . '.jpg',
                'products/gallery/' . Str::random(12) . '.jpg',
            ],
            'description' => $this->faker->paragraph(5),

            // Pricing
            'original_price' => $originalPrice,
            'discount' => $discount,
            'price' => $price,

            // Status
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(30),

            // Rating
            'rating' => $this->faker->optional()->randomFloat(1, 1, 5),
        ];
    }
}
