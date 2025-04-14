<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        // Products for Sedan category
        $sedanCategory = $categories->where('name', 'Sedan')->first();
        if ($sedanCategory) {
            $this->createSedanProducts($sedanCategory->id);
        }
        
        // Products for SUV category
        $suvCategory = $categories->where('name', 'SUV')->first();
        if ($suvCategory) {
            $this->createSUVProducts($suvCategory->id);
        }
        
        // Products for Hatchback category
        $hatchbackCategory = $categories->where('name', 'Hatchback')->first();
        if ($hatchbackCategory) {
            $this->createHatchbackProducts($hatchbackCategory->id);
        }
        
        // Products for Luxury category
        $luxuryCategory = $categories->where('name', 'Luxury')->first();
        if ($luxuryCategory) {
            $this->createLuxuryProducts($luxuryCategory->id);
        }
        
        // Products for Sports Car category
        $sportsCategory = $categories->where('name', 'Sports Car')->first();
        if ($sportsCategory) {
            $this->createSportsProducts($sportsCategory->id);
        }
        
        // Products for Electric category
        $electricCategory = $categories->where('name', 'Electric')->first();
        if ($electricCategory) {
            $this->createElectricProducts($electricCategory->id);
        }
    }
    
    private function createSedanProducts($categoryId)
    {
        $products = [
            [
                'name' => 'Toyota Camry',
                'description' => 'The reliable and comfortable Toyota Camry sedan',
                'details' => 'Engine: 2.5L 4-cylinder, Transmission: 8-speed automatic, MPG: 29 city / 41 highway',
                'price' => 28000,
                'sale_price' => 26500,
                'quantity' => 15,
                'image' => 'products/camry.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => true
            ],
            [
                'name' => 'Honda Accord',
                'description' => 'The stylish and efficient Honda Accord sedan',
                'details' => 'Engine: 1.5L Turbo 4-cylinder, Transmission: CVT, MPG: 30 city / 38 highway',
                'price' => 27500,
                'sale_price' => null,
                'quantity' => 12,
                'image' => 'products/accord.jpg',
                'featured' => true,
                'is_new' => false,
                'on_sale' => false
            ],
            [
                'name' => 'Nissan Altima',
                'description' => 'The comfortable and affordable Nissan Altima sedan',
                'details' => 'Engine: 2.5L 4-cylinder, Transmission: CVT, MPG: 28 city / 39 highway',
                'price' => 25500,
                'sale_price' => 24000,
                'quantity' => 8,
                'image' => 'products/altima.jpg',
                'featured' => false,
                'is_new' => false,
                'on_sale' => true
            ]
        ];
        
        $this->createProducts($products, $categoryId);
    }
    
    private function createSUVProducts($categoryId)
    {
        $products = [
            [
                'name' => 'Toyota RAV4',
                'description' => 'The versatile and capable Toyota RAV4 SUV',
                'details' => 'Engine: 2.5L 4-cylinder, Transmission: 8-speed automatic, MPG: 27 city / 35 highway',
                'price' => 31000,
                'sale_price' => 29500,
                'quantity' => 10,
                'image' => 'products/rav4.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => true
            ],
            [
                'name' => 'Honda CR-V',
                'description' => 'The spacious and reliable Honda CR-V SUV',
                'details' => 'Engine: 1.5L Turbo 4-cylinder, Transmission: CVT, MPG: 28 city / 34 highway',
                'price' => 32000,
                'sale_price' => null,
                'quantity' => 9,
                'image' => 'products/crv.jpg',
                'featured' => true,
                'is_new' => false,
                'on_sale' => false
            ],
            [
                'name' => 'Ford Explorer',
                'description' => 'The powerful and spacious Ford Explorer SUV',
                'details' => 'Engine: 2.3L EcoBoost, Transmission: 10-speed automatic, MPG: 21 city / 28 highway',
                'price' => 38000,
                'sale_price' => 36000,
                'quantity' => 6,
                'image' => 'products/explorer.jpg',
                'featured' => false,
                'is_new' => true,
                'on_sale' => true
            ]
        ];
        
        $this->createProducts($products, $categoryId);
    }
    
    private function createHatchbackProducts($categoryId)
    {
        $products = [
            [
                'name' => 'Honda Civic Hatchback',
                'description' => 'The sporty and practical Honda Civic Hatchback',
                'details' => 'Engine: 1.5L Turbo 4-cylinder, Transmission: CVT, MPG: 31 city / 40 highway',
                'price' => 25500,
                'sale_price' => null,
                'quantity' => 14,
                'image' => 'products/civic-hatch.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => false
            ],
            [
                'name' => 'Mazda 3 Hatchback',
                'description' => 'The elegant and fun-to-drive Mazda 3 Hatchback',
                'details' => 'Engine: 2.5L 4-cylinder, Transmission: 6-speed automatic, MPG: 26 city / 35 highway',
                'price' => 27000,
                'sale_price' => 25500,
                'quantity' => 7,
                'image' => 'products/mazda3-hatch.jpg',
                'featured' => false,
                'is_new' => false,
                'on_sale' => true
            ]
        ];
        
        $this->createProducts($products, $categoryId);
    }
    
    private function createLuxuryProducts($categoryId)
    {
        $products = [
            [
                'name' => 'Mercedes-Benz S-Class',
                'description' => 'The pinnacle of luxury and technology',
                'details' => 'Engine: 3.0L Inline-6 Turbo, Transmission: 9-speed automatic, MPG: 22 city / 29 highway',
                'price' => 110000,
                'sale_price' => null,
                'quantity' => 5,
                'image' => 'products/s-class.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => false
            ],
            [
                'name' => 'BMW 7 Series',
                'description' => 'The ultimate driving luxury sedan',
                'details' => 'Engine: 3.0L Twin-Turbo 6-cylinder, Transmission: 8-speed automatic, MPG: 22 city / 29 highway',
                'price' => 95000,
                'sale_price' => 92000,
                'quantity' => 4,
                'image' => 'products/7-series.jpg',
                'featured' => true,
                'is_new' => false,
                'on_sale' => true
            ],
            [
                'name' => 'Audi A8',
                'description' => 'The sophisticated and tech-forward luxury sedan',
                'details' => 'Engine: 3.0L V6 Turbo, Transmission: 8-speed automatic, MPG: 21 city / 29 highway',
                'price' => 88000,
                'sale_price' => null,
                'quantity' => 3,
                'image' => 'products/a8.jpg',
                'featured' => false,
                'is_new' => true,
                'on_sale' => false
            ]
        ];
        
        $this->createProducts($products, $categoryId);
    }
    
    private function createSportsProducts($categoryId)
    {
        $products = [
            [
                'name' => 'Porsche 911',
                'description' => 'The iconic and exhilarating Porsche 911 sports car',
                'details' => 'Engine: 3.0L Twin-Turbo 6-cylinder, Transmission: 8-speed PDK, 0-60 mph: 3.5 seconds',
                'price' => 115000,
                'sale_price' => null,
                'quantity' => 3,
                'image' => 'products/911.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => false
            ],
            [
                'name' => 'Chevrolet Corvette',
                'description' => 'The powerful American sports car',
                'details' => 'Engine: 6.2L V8, Transmission: 8-speed dual-clutch, 0-60 mph: 2.9 seconds',
                'price' => 65000,
                'sale_price' => 62000,
                'quantity' => 5,
                'image' => 'products/corvette.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => true
            ]
        ];
        
        $this->createProducts($products, $categoryId);
    }
    
    private function createElectricProducts($categoryId)
    {
        $products = [
            [
                'name' => 'Tesla Model 3',
                'description' => 'The popular and efficient Tesla Model 3 electric sedan',
                'details' => 'Range: 358 miles, 0-60 mph: 3.1 seconds, Dual Motor All-Wheel Drive',
                'price' => 48000,
                'sale_price' => null,
                'quantity' => 10,
                'image' => 'products/model3.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => false
            ],
            [
                'name' => 'Nissan Leaf',
                'description' => 'The affordable and practical Nissan Leaf electric hatchback',
                'details' => 'Range: 226 miles, Motor: 147 hp electric, Battery: 62 kWh',
                'price' => 32000,
                'sale_price' => 30000,
                'quantity' => 12,
                'image' => 'products/leaf.jpg',
                'featured' => false,
                'is_new' => false,
                'on_sale' => true
            ],
            [
                'name' => 'Ford Mustang Mach-E',
                'description' => 'The exciting and capable Ford Mustang Mach-E electric SUV',
                'details' => 'Range: 314 miles, 0-60 mph: 3.5 seconds, Dual Motor All-Wheel Drive',
                'price' => 52000,
                'sale_price' => null,
                'quantity' => 7,
                'image' => 'products/mach-e.jpg',
                'featured' => true,
                'is_new' => true,
                'on_sale' => false
            ]
        ];
        
        $this->createProducts($products, $categoryId);
    }
    
    private function createProducts($products, $categoryId)
    {
        foreach ($products as $product) {
            Product::create([
                'category_id' => $categoryId,
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'details' => $product['details'],
                'price' => $product['price'],
                'sale_price' => $product['sale_price'],
                'quantity' => $product['quantity'],
                'image' => $product['image'],
                'featured' => $product['featured'],
                'is_new' => $product['is_new'],
                'on_sale' => $product['on_sale']
            ]);
        }
    }
}
