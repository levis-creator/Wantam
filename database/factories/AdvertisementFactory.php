<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'image' => 'advertisements/' . $this->faker->image(
                dir: storage_path('app/public/advertisements'),
                width: 1200,
                height: 400,
                category: 'business',
                fullPath: false
            ),
            'link' => $this->faker->optional(0.7)->url(), // 70% chance of having a link
            'product_id' => $this->faker->optional(0.6)->randomElement(Product::pluck('id')->toArray()),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'ends_at' => $this->faker->optional(0.8)->dateTimeBetween('+1 month', '+3 months'),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        return $this->afterCreating(function (Advertisement $advertisement) {
            // Ensure ends_at is after starts_at if both exist
            if (
                $advertisement->starts_at && $advertisement->ends_at &&
                $advertisement->starts_at > $advertisement->ends_at
            ) {
                $advertisement->update([
                    'ends_at' => $this->faker->dateTimeBetween(
                        $advertisement->starts_at,
                        $advertisement->starts_at->modify('+3 months')
                    )
                ]);
            }
        });
    }
    public function active(): self
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive(): self
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function current(): self
    {
        return $this->state([
            'starts_at' => now()->subDays(rand(1, 10)),
            'ends_at' => now()->addDays(rand(1, 30)),
            'is_active' => true,
        ]);
    }
}
