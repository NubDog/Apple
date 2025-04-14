<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Luxury Cars for Every Budget',
                'subtitle' => 'Explore our premium collection with special financing',
                'image' => 'sliders/luxury-slider.jpg',
                'link' => '/category/luxury',
                'order' => 1,
                'status' => true
            ],
            [
                'title' => 'New Electric Vehicles',
                'subtitle' => 'Discover the future of driving with zero emissions',
                'image' => 'sliders/electric-slider.jpg',
                'link' => '/category/electric',
                'order' => 2,
                'status' => true
            ],
            [
                'title' => 'Family SUVs on Sale',
                'subtitle' => 'Find the perfect vehicle for your family adventures',
                'image' => 'sliders/suv-slider.jpg',
                'link' => '/category/suv',
                'order' => 3,
                'status' => true
            ],
            [
                'title' => 'Sports Cars Special Offer',
                'subtitle' => 'Experience the thrill of driving performance vehicles',
                'image' => 'sliders/sports-slider.jpg',
                'link' => '/category/sports-car',
                'order' => 4,
                'status' => true
            ],
            [
                'title' => 'Sedans for Every Driver',
                'subtitle' => 'Comfort, efficiency, and style for daily commutes',
                'image' => 'sliders/sedan-slider.jpg',
                'link' => '/category/sedan',
                'order' => 5,
                'status' => true
            ]
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
