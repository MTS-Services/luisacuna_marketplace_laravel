<?php

namespace Database\Seeders;

use App\Models\WithdrawalGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithdrawalGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WithdrawalGateway::insert([
            [
                'name' => 'PayPal',
                'slug' => 'paypal'
            ],
            [
                'name' => 'Payoneer',
                'slug' => 'payoneer'
            ]
        ]);
    }
}
