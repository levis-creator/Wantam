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
        $categories = [
            [
                'image' => 'categories/banner-5.jpg',
                'name' => "Women's",
                'slug' => 'women',
                'is_active' => true,
                'is_featured' => true,
                'description' => 'Shop stylish and trending women’s wear.',
            ],
            [
                'image' => 'categories/banner-6.jpg',
                'name' => "Men's",
                'slug' => 'men',
                'is_active' => true,
                'is_featured' => true,
                'description' => 'Discover modern fashion for men.',
            ],
            [
                'image' => 'categories/banner-7.jpg',
                'name' => "Kid's",
                'slug' => 'kids',
                'is_active' => true,
                'is_featured' => false,
                'description' => 'Trendy and fun outfits for kids.',
            ],
        ];

        foreach ($categories as $data) {
            Category::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'image' => $data['image'], // This should be relative to `storage`
                'is_active' => $data['is_active'],
                'is_featured' => $data['is_featured'],
                'parent_id' => null,
            ]);
        }

        $this->command->info('Seeded featured categories with images.');
        // Create 5 active top-level categories
        $topLevelCategories = Category::factory()
            ->count(5)
            ->active()
            ->create();

        $this->command->info('Top-level active categories created: ' . $topLevelCategories->count());

        foreach ($topLevelCategories as $parent) {
            // Active child categories
            $activeChildren = Category::factory()
                ->count(2)
                ->active()
                ->withParent($parent)
                ->create();

            // Inactive child categories
            $inactiveChildren = Category::factory()
                ->count(1)
                ->inactive()
                ->withParent($parent)
                ->create();

            $this->command->info("Parent '{$parent->name}' has " . $activeChildren->count() . " active and " . $inactiveChildren->count() . " inactive children.");
        }

        // Create 2 inactive top-level categories
        $inactiveTopLevel = Category::factory()
            ->count(2)
            ->inactive()
            ->create();

        $this->command->info('Inactive top-level categories created: ' . $inactiveTopLevel->count());
    }
}
