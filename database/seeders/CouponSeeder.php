<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10,
                'min_order_amount' => 1000,
                'max_uses' => 100,
                'used_times' => 0,
                'is_active' => true,
                'expires_at' => now()->addMonths(3)
            ],
            [
                'code' => 'SUMMER25',
                'type' => 'percent',
                'value' => 25,
                'min_order_amount' => 5000,
                'max_uses' => 50,
                'used_times' => 0,
                'is_active' => true,
                'expires_at' => now()->addMonths(2)
            ],
            [
                'code' => 'FLAT500',
                'type' => 'fixed',
                'value' => 500,
                'min_order_amount' => 2000,
                'max_uses' => 30,
                'used_times' => 0,
                'is_active' => true,
                'expires_at' => now()->addMonths(1)
            ],
            [
                'code' => 'VIP15',
                'type' => 'percent',
                'value' => 15,
                'min_order_amount' => 3000,
                'max_uses' => 100,
                'used_times' => 0,
                'is_active' => true,
                'expires_at' => now()->addMonths(6)
            ]
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
