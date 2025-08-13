<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 generic advertisements if none exist
        if (Advertisement::count() === 0) {
            Advertisement::factory(5)->create();
        }

        // Specific advertisements from dummy data
        $dummyData = [
            [
                'title' => 'Sneakers & Athletic Shoes',
                'subtitle' => 'Deals and Promotions',
                'price' => 'from $9.99',
                'image_default' => 'advertisements/slide-1.jpg',
                'image_mobile' => 'advertisements/slide-1-480w.jpg',
                'default_alt' => 'Sneakers and athletic shoes promotion',
                'link' => 'category.html',
                'starts_at' => now()->subDays(10),
                'ends_at' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'title' => "This Week's Most Wanted",
                'subtitle' => 'Trending Now',
                'price' => 'from $49.99',
                'image_default' => 'advertisements/slide-2.jpg',
                'image_mobile' => 'advertisements/slide-2-480w.jpg',
                'default_alt' => 'Trending products this week',
                'link' => 'category.html',
                'starts_at' => now()->subDays(5),
                'ends_at' => now()->addDays(20),
                'is_active' => true,
            ],
            [
                'title' => "Can’t-miss Clearance",
                'subtitle' => 'Deals and Promotions',
                'price' => 'starting at 60% off',
                'image_default' => 'advertisements/slide-3.jpg',
                'image_mobile' => 'advertisements/slide-3-480w.jpg',
                'default_alt' => 'Clearance sale advertisement',
                'link' => 'category.html',
                'starts_at' => now(),
                'ends_at' => now()->addDays(15),
                'is_active' => true,
            ],
        ];

        // Create or update specific advertisements to avoid duplicates
        foreach ($dummyData as $data) {
            Advertisement::updateOrCreate(
                ['title' => $data['title']], // Unique key to check for existing records
                $data
            );
        }
    }
}
