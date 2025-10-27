<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ExchangeRateHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExchangeRateHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExchangeRateHistory::insert([
            [
                'sort_order' => 1,
                'base_currency' => 1,
                'target_currency' => 2,
                'rate' => 0.93,
                'last_updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'base_currency' => 1,
                'target_currency' => 3,
                'rate' => 0.81,
                'last_updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'base_currency' => 1,
                'target_currency' => 4,
                'rate' => 118.25,
                'last_updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 4,
                'base_currency' => 2,
                'target_currency' => 4,
                'rate' => 127.02,
                'last_updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
