<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are products and users to relate to
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No users or products found. Seeding some for testing...');
            User::factory(5)->create();
            Product::factory(5)->create();
        }

        // Re-fetch after ensuring they exist
        $users = User::all();
        $products = Product::all();

        // Create 50 reviews distributed randomly
        foreach (range(1, 50) as $i) {
            Review::factory()->create([
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
            ]);
        }
    }
}
