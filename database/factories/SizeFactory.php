<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Size>
 */
class SizeFactory extends Factory
{
    protected $model = Size::class;

    public function definition(): array
    {
        $sizeValue = $this->faker->randomElement(['S', 'M', 'L', 'XL', '8', '9.5', '10', '42', '43']);
        $label = match ($sizeValue) {
            'S', 'M', 'L', 'XL' => 'Size ' . $sizeValue,
            default => 'EU ' . $sizeValue,
        };

        return [
            'id' => Str::uuid()->toString(),
            'name' => $sizeValue,
            'label' => $label,
        ];
    }
}
