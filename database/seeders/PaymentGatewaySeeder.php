<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'sort_order' => 1,
                'name' => 'Stripe',
                'slug' => 'stripe',
                'icon' => null,
                'data' => json_encode([
                    'public_key' => config('services.stripe.key'),
                    'secret_key' => config('services.stripe.secret'),
                ]),
                'is_active' => true,
            ],
            [
                'sort_order' => 2,
                'name' => 'PayPal',
                'slug' => 'paypal',
                'icon' => null,
                'data' => json_encode([
                    'client_id' => '',
                    'secret' => '',
                ]),
                'is_active' => true,
            ],
            [
                'sort_order' => 3,
                'name' => 'Coinbase',
                'slug' => 'coinbase',
                'icon' => null,
                'data' => json_encode([
                    'api_key' => config('services.coinbase.api_key'),
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['slug' => $gateway['slug']],
                $gateway
            );
        }
    }
}
