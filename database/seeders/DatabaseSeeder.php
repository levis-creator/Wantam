<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
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
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            AdvertisementSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            ProductVariantSeeder::class,
            ReviewSeeder::class,
            CartSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PaymentSeeder::class,
            WishlistSeeder::class,
            ShippingSeeder::class,
            AddressSeeder::class
        ]);
    }
}
