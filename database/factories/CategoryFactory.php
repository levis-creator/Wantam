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
        $slug = Str::slug($name) . '-' . Str::random(4); // ensure uniqueness

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->sentence(),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'categories'),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(40),
            'parent_id' => null,
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
     * Assign a parent category.
     */
    public function withParent(Category $parent): static
    {
        return $this->state(fn() => ['parent_id' => $parent->id]);
    }

    /**
     * Assign a random existing category as parent (optional helper).
     */
    public function randomParent(): static
    {
        return $this->state(function () {
            $parent = Category::inRandomOrder()->first();
            return ['parent_id' => $parent?->id];
        });
    }
}
