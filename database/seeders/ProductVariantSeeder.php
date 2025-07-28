<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure related data exists
        $sizes = Size::all();
        $colors = Color::all();

        // If sizes or colors don't exist, create some
        if ($sizes->isEmpty()) {
            $sizes = Size::factory()->count(5)->create();
        }

        if ($colors->isEmpty()) {
            $colors = Color::factory()->count(5)->create();
        }

        // Seed variants for each product
        Product::all()->each(function ($product) use ($sizes, $colors) {
            foreach ($sizes->random(2) as $size) {
                foreach ($colors->random(2) as $color) {
                    ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'size_id' => $size->id,
                        'color_id' => $color->id,
                    ]);
                }
            }
        });
    }
}
