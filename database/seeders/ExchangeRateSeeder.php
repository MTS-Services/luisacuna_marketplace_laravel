<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ExchangeRate::insert([
            [
                'sort_order' => 1,
                'base_currency' => 1, // USD
                'target_currency' => 2, // EUR
                'rate' => 0.93,
                'last_updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'base_currency' => 1, // USD
                'target_currency' => 3, // GBP
                'rate' => 0.81,
                'last_updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'base_currency' => 1, // USD
                'target_currency' => 4, // BDT
                'rate' => 118.25,
                'last_updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 4,
                'base_currency' => 2, // EUR
                'target_currency' => 4, // BDT
                'rate' => 127.02,
                'last_updated_at' => Carbon::now(),
            ],
        ]);
    }
}
