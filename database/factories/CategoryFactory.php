<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name), // parent-child slug handling is done in model boot
            'description' => $this->faker->sentence(),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'categories'),
            'is_active' => $this->faker->boolean(90),
            'parent_id' => null, // can be filled in a seeder to simulate nesting
        ];
    }

    /**
     * Create an active category.
     */
    public function active(): static
    {
        return $this->state(fn() => ['is_active' => true]);
    }

    /**
     * Create an inactive category.
     */
    public function inactive(): static
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    /**
     * Assign a parent category (for nested categories).
     */
    public function withParent(Category $parent): static
    {
        return $this->state(fn() => [
            'parent_id' => $parent->id,
        ]);
    }
}
