<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop through existing users and assign them 1–3 addresses
        User::all()->each(function ($user) {
            $addresses = Address::factory()->count(rand(1, 3))->create([
                'user_id' => $user->id,
            ]);

            // Set the first address as default if none is marked
            if (!$addresses->contains('is_default', true)) {
                $addresses->first()->update(['is_default' => true]);
            }
        });
    }
}
