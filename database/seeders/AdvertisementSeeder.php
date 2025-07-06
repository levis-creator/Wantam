<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random advertisements
        Advertisement::factory()->count(10)->create();

        // Create some specific test cases
        Advertisement::factory()->create([
            'title' => 'Summer Sale Banner',
            'image' => 'advertisements/summer-sale.jpg', // You should have this image in your storage
            'link' => '/summer-sale',
            'is_active' => true,
            'starts_at' => now()->subDays(3),
            'ends_at' => now()->addWeeks(2),
        ]);

        Advertisement::factory()->create([
            'title' => 'New Product Launch',
            'image' => 'advertisements/new-product.jpg',
            'is_active' => true,
            'starts_at' => now()->subWeek(),
            'ends_at' => null, // No end date - will run indefinitely
        ]);

        Advertisement::factory()->create([
            'title' => 'Expired Promotion',
            'image' => 'advertisements/expired-promo.jpeg',
            'is_active' => false,
            'starts_at' => now()->subMonths(2),
            'ends_at' => now()->subMonth(),
        ]);

        // Create 5 active current advertisements
        Advertisement::factory()
            ->count(5)
            ->active()
            ->state([
                'starts_at' => now()->subDays(rand(1, 10)),
                'ends_at' => now()->addDays(rand(1, 30)),
            ])
            ->create();

        // Create 3 inactive advertisements
        Advertisement::factory()
            ->count(3)
            ->inactive()
            ->create();
    }
}
