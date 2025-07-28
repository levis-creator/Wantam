<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create regular users
        User::factory(10)->create();

        // Create test admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::Admin, // Use enum here
        ]);

        // Create test regular user
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::User, // Use enum here
        ]);
    }
}
