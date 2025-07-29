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
            'order_id' => Order::factory(), // or use an existing order
            'address_id' => Address::factory(),
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'tracking_number' => $this->faker->optional()->regexify('[A-Z0-9]{10}'),
            'status' => $this->faker->randomElement(['pending', 'shipped', 'delivered']),
        ];
    }
}
