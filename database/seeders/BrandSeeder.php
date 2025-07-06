<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 8 active brands (70% will have logos)
        Brand::factory(8)->active()->create();

        // Create 2 inactive brands
        Brand::factory(2)->inactive()->create();

        // Create 2 brands without logos
        Brand::factory(2)->withoutLogo()->create();

        // Create specific demo brands
        Brand::factory()->create([
            'name' => 'Nike',
            'slug' => 'nike',
            'description' => 'Just Do It - Athletic footwear and apparel',
            'is_active' => true
        ]);

        Brand::factory()->create([
            'name' => 'Apple',
            'slug' => 'apple',
            'description' => 'Think different - Technology and electronics',
            'is_active' => true
        ]);
    }
}
