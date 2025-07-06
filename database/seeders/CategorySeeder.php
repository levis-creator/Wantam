<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 active top-level categories
        $topLevelCategories = Category::factory()
            ->count(5)
            ->active()
            ->create();

        // For each top-level category, create 2 child categories (active and inactive)
        foreach ($topLevelCategories as $parent) {
            // Active child categories
            Category::factory()
                ->count(2)
                ->active()
                ->withParent($parent)
                ->create();

            // Inactive child categories
            Category::factory()
                ->count(1)
                ->inactive()
                ->withParent($parent)
                ->create();
        }

        // Optionally add some inactive top-level categories too
        Category::factory()
            ->count(2)
            ->inactive()
            ->create();
    }
}
