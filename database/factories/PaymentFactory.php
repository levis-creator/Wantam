<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $paymentMethod = $this->faker->randomElement(['mpesa', 'card', 'paypal']);
        $amount = $this->faker->randomFloat(2, 100, 5000);

        return [
            'id' => Str::uuid()->toString(),
            'order_id' => Order::factory(), // ensures each payment belongs to an order
            'payment_method' => $paymentMethod,
            'transaction_id' => $this->faker->uuid(),
            'amount' => $amount,
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'paid_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
