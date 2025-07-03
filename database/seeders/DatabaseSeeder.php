<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create regular users
        User::factory(10)->create();

        // Create test admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Always use Hash for passwords
            'role' => User::ROLE_ADMIN,
        ]);

        // Create test regular user
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_USER,
        ]);

        // Create categories with realistic data
        Category::factory(5)->create([
            'is_active' => true,
        ]);

        // Create some inactive categories
        Category::factory(2)->inactive()->create();
    }
}
