<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::insert([
             [
                'sort_order' => 1,
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'US Dollar',
                'exchange_rate' => 1.00,
                'decimal_places' => 2,
                'status' => 'active',
                'is_default' => true,
            ],
            [
                'sort_order' => 2,
                'code' => 'EUR',
                'symbol' => '€',
                'name' => 'Euro',
                'exchange_rate' => 0.90,
                'decimal_places' => 2,
                'status' => 'active',
                'is_default' => false,
            ],
            [
                'sort_order' => 3,
                'code' => 'GBP',
                'symbol' => '£',
                'name' => 'British Pound',
                'exchange_rate' => 0.78,
                'decimal_places' => 2,
                'status' => 'active',
                'is_default' => false,
            ],
            [
                'sort_order' => 4,
                'code' => 'BDT',
                'symbol' => '৳',
                'name' => 'Bangladeshi Taka',
                'exchange_rate' => 110.00,
                'decimal_places' => 2,
                'status' => 'active',
                'is_default' => false,
            ],
        ]);
    }
}
