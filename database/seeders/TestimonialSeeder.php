<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'John Doe',
                'avatar' => 'avatars/john-doe.jpg',
                'designation' => 'CEO, Tech Solutions',
                'content' => 'This product has completely transformed our workflow. Highly recommended!',
                'rating' => 5,
                'status' => true
            ],
            [
                'name' => 'Jane Smith',
                'avatar' => 'avatars/jane-smith.jpg',
                'designation' => 'Marketing Director',
                'content' => 'Excellent quality and outstanding customer service. Will definitely buy again.',
                'rating' => 4,
                'status' => true
            ],
            [
                'name' => 'Robert Johnson',
                'avatar' => 'avatars/robert-johnson.jpg',
                'designation' => 'Product Manager',
                'content' => 'The attention to detail and quality is impressive. Worth every penny!',
                'rating' => 5,
                'status' => true
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
} 