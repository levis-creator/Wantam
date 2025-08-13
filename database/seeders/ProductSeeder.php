<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Load dummy products from file
        $dummyProducts = include database_path('seeders/data/dummy_products.php');

        foreach ($dummyProducts as $item) {
            // Create or get first matching category
            $categoryName = $item['categories'][0];
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => \Illuminate\Support\Str::slug($categoryName)]
            );

            // Create or get brand
            $brand = Brand::firstOrCreate(
                ['name' => 'Generic'],
                ['slug' => \Illuminate\Support\Str::slug('Generic')]
            );

            // Create product
            $product = Product::create([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => $item['name'],
                'main_image' => $item['main_image'],
                'images' => $item['images'],
                'description' => fake()->paragraph(4),
                'original_price' => $item['original_price'],
                'discount' => $item['discount'],
                'is_active' => $item['is_active'],
                'is_featured' => $item['is_featured'],
            ]);

            // Create reviews
            for ($i = 0; $i < $item['reviews_count']; $i++) {
                Review::factory()->create([
                    'product_id' => $product->id,
                    'rating' => rand(2, 5),
                ]);
            }
        }
    }
}
