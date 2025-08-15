<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'id'          => Str::uuid()->toString(),
            'user_id'     => User::factory(),
            'name'        => fake()->name(),
            'phone'       => fake()->phoneNumber(),
            'address'     => fake()->streetAddress(),
            'city'        => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country'     => fake()->country(),
            'is_default'  => fake()->boolean(20), // 20% chance to be default
        ];
    }
}
