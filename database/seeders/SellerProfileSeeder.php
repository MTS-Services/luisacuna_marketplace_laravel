<?php

namespace Database\Seeders;

use App\Models\SellerProfile;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SellerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SellerProfile::insert([
            [
                'sort_order' => 1,
                'user_id' => 1,
                'shop_name' => 'Best Electronics',
                'shop_description' => 'We sell the best electronics at affordable prices.',
                'seller_verified' => true,
                'seller_verified_at' => Carbon::now(),
                'seller_level' => 'bronze',
                'commission_rate' => 10.00,
                'minimum_payout' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'user_id' => 2,
                'shop_name' => 'Fashion Hub',
                'shop_description' => 'Trendy fashion items for all ages.',
                'seller_verified' => false,
                'seller_verified_at' => null,
                'seller_level' => 'bronze',
                'commission_rate' => 10.00,
                'minimum_payout' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
