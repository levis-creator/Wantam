<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'id'             => Str::uuid()->toString(),
            'user_id'        => User::factory(),

            // Random status: pending, processing, completed, cancelled
            'status'         => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),

            // Payment method
            'payment_method' => fake()->randomElement(['mpesa', 'paypal', 'card', 'cash_on_delivery']),

            // Shipping address
            'address_id'     => Address::factory(),

            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
