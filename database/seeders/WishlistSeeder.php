<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Users or Products missing. Seeding aborted.');
            return;
        }

        $combinations = [];

        foreach ($users as $user) {
            $items = $products->random(rand(2, 5));
            foreach ($items as $product) {
                $key = "{$user->id}-{$product->id}";

                if (!isset($combinations[$key])) {
                    Wishlist::factory()->create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                    ]);
                    $combinations[$key] = true;
                }
            }
        }
    }
}
