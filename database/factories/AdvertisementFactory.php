<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+2 months');
        $imageNumber = $this->faker->numberBetween(1, 5); // Simulate slide-1 to slide-5
        $subtitles = ['Deals and Promotions', 'Trending Now', 'New Arrivals', 'Limited Offer'];
        $titles = [
            'Sneakers & Athletic Shoes',
            "This Week's Most Wanted",
            "Can’t-miss Clearance",
            'Top Picks for You',
            'Exclusive Collections',
        ];
        $prices = ['from $9.99', 'from $49.99', 'starting at 60% off', 'from $19.99', 'up to 50% off'];

        return [
            'id' => Str::uuid()->toString(),
            'title' => $this->faker->randomElement($titles),
            'subtitle' => $this->faker->randomElement($subtitles),
            'price' => $this->faker->randomElement($prices),
            'image_default' => 'advertisements/slide-' . $imageNumber . '.jpg',
            'image_mobile' => 'advertisements/slide-' . $imageNumber . '-480w.jpg',
            'default_alt' => $this->faker->sentence(4), // Generate alt text for accessibility
            'link' => $this->faker->optional(0.8, 'category.html')->url(), // 80% chance of a link
            'product_id' => $this->faker->optional(0.5)->randomElement(Product::pluck('id')->toArray()), // 50% chance of linking to a product
            'starts_at' => $startDate,
            'ends_at' => $endDate,
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
