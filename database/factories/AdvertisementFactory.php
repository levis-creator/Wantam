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

        return [
            'id' => Str::uuid()->toString(),
            'title' => $this->faker->optional()->sentence(3),
            'image' => 'advertisements/' . Str::random(10) . '.jpg',
            'link' => $this->faker->optional()->url(),
            'product_id' => Product::factory(), // or null
            'starts_at' => $startDate,
            'ends_at' => $endDate,
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
