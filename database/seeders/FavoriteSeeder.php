<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get regular users
        $users = User::where('role', 'user')->get();
        
        // Get products
        $products = Product::all();
        
        // Add favorites for each user
        foreach ($users as $user) {
            // Skip for some users
            if (rand(0, 3) === 0) {
                continue;
            }
            
            // Add 1-5 random favorites for each user
            $numberOfFavorites = rand(1, 5);
            $randomProducts = $products->random($numberOfFavorites);
            
            foreach ($randomProducts as $product) {
                Favorite::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id
                ]);
            }
        }
    }
}
