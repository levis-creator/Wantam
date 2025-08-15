<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ColorFactory extends Factory
{
    protected $model = Color::class;

    public function definition(): array
    {
        // Sample color names and corresponding hex codes
        $colorData = [
            ['name' => 'Red', 'hex' => '#FF0000'],
            ['name' => 'Green', 'hex' => '#00FF00'],
            ['name' => 'Blue', 'hex' => '#0000FF'],
            ['name' => 'Black', 'hex' => '#000000'],
            ['name' => 'White', 'hex' => '#FFFFFF'],
            ['name' => 'Yellow', 'hex' => '#FFFF00'],
            ['name' => 'Purple', 'hex' => '#800080'],
            ['name' => 'Gray', 'hex' => '#808080'],
        ];

        $color = fake()->randomElement($colorData);

        return [
            'id' => Str::uuid()->toString(),
            'name' => $color['name'],
            'hex' => $color['hex'],
        ];
    }
}
