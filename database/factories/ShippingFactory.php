<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShippingFactory extends Factory
{
    protected $model = Shipping::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'order_id' => Order::factory(),
            'address_id' => Address::factory(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
            'tracking_number' => fake()->optional()->regexify('[A-Z0-9]{10}'),
            'status' => fake()->randomElement(['pending', 'shipped', 'delivered']),
        ];
    }
}
