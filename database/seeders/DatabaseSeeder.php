<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,            // First create users
            CategorySeeder::class,        // Then create categories
            ProductSeeder::class,         // Then create products within categories
            SliderSeeder::class,          // Create sliders
            CouponSeeder::class,          // Create coupons
            ContactSeeder::class,         // Create contact messages
            OrderSeeder::class,           // Create orders (needs users and products)
            FavoriteSeeder::class,        // Create user favorites (needs users and products)
        ]);
    }
}
