<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::insert([
            [
                'sort_order' => 1,
                'name' => 'United States',
                'code' => 'US',
                'phone_code' => '+1',
                'currency' => 'USD',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'name' => 'United Kingdom',
                'code' => 'GB',
                'phone_code' => '+44',
                'currency' => 'GBP',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'name' => 'Bangladesh',
                'code' => 'BD',
                'phone_code' => '+880',
                'currency' => 'BDT',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
