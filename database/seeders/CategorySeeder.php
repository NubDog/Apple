<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sedan',
                'description' => 'Four-door passenger cars with a separate trunk',
                'image' => 'categories/sedan.jpg'
            ],
            [
                'name' => 'SUV',
                'description' => 'Sport Utility Vehicles with raised ground clearance',
                'image' => 'categories/suv.jpg'
            ],
            [
                'name' => 'Hatchback',
                'description' => 'Compact cars with a rear door that opens upwards',
                'image' => 'categories/hatchback.jpg'
            ],
            [
                'name' => 'Luxury',
                'description' => 'High-end vehicles with premium features',
                'image' => 'categories/luxury.jpg'
            ],
            [
                'name' => 'Sports Car',
                'description' => 'High-performance vehicles designed for speed',
                'image' => 'categories/sports.jpg'
            ],
            [
                'name' => 'Electric',
                'description' => 'Vehicles powered by electric motors',
                'image' => 'categories/electric.jpg'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image']
            ]);
        }
    }
}
