<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 advertisements with associated products
        Advertisement::factory()->count(5)->create();

        // Create 5 advertisements without linked products
        Advertisement::factory()->count(5)->create([
            'product_id' => null,
        ]);
    }
}
