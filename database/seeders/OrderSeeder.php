<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get regular users (not admin)
        $users = User::where('role', 'user')->get();
        
        // Get available products
        $products = Product::all();
        
        // Create sample orders for each user
        foreach ($users as $index => $user) {
            // Skip creating orders for some users to have variety
            if ($index % 3 === 0) {
                continue;
            }
            
            $statusOptions = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
            $paymentOptions = ['cod', 'bank_transfer'];
            
            // Create 1-3 orders per user
            $numberOfOrders = rand(1, 3);
            
            for ($i = 0; $i < $numberOfOrders; $i++) {
                // Random status, biased towards 'delivered' for older orders
                $status = $statusOptions[array_rand($statusOptions)];
                $paymentMethod = $paymentOptions[array_rand($paymentOptions)];
                
                // Calculate random date in past 30 days
                $daysAgo = rand(1, 30);
                $orderDate = now()->subDays($daysAgo);
                
                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => $status,
                    'total' => 0, // Will be calculated based on items
                    'subtotal' => 0, // Will be calculated based on items
                    'tax' => 0,
                    'shipping_cost' => rand(0, 2) ? 0 : 1500, // Sometimes free shipping
                    'discount' => 0,
                    'coupon_code' => null,
                    'shipping_name' => $user->name,
                    'shipping_email' => $user->email,
                    'shipping_phone' => $user->phone,
                    'shipping_address' => $user->address,
                    'notes' => rand(0, 1) ? 'Please deliver during business hours.' : null,
                    'payment_method' => $paymentMethod,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
                
                // Add 1-3 random products to order
                $numberOfItems = rand(1, 3);
                $subtotal = 0;
                
                for ($j = 0; $j < $numberOfItems; $j++) {
                    $randomProduct = $products->random();
                    $quantity = rand(1, 2);
                    $price = $randomProduct->on_sale && $randomProduct->sale_price ? $randomProduct->sale_price : $randomProduct->price;
                    $itemSubtotal = $price * $quantity;
                    $subtotal += $itemSubtotal;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $randomProduct->id,
                        'product_name' => $randomProduct->name,
                        'price' => $price,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);
                }
                
                // Update order totals
                $total = $subtotal + $order->shipping_cost + $order->tax - $order->discount;
                $order->update([
                    'subtotal' => $subtotal,
                    'total' => $total
                ]);
            }
        }
    }
}
