<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have some users, products, and variants
        $users = User::all();
        $products = Product::with('variants')->get();

        foreach ($users as $user) {
            // Assign 1–3 random cart items per user
            foreach ($products->random(rand(1, 3)) as $product) {
                $variant = $product->variants->random() ?? null;

                Cart::factory()->create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant?->id,
                ]);
            }
        }
    }
}
