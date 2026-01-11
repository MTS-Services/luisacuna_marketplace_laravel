<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
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
                'live_data' => [
                    'public_key' => config('services.stripe.key'),
                    'secret_key' => config('services.stripe.secret'),
                ],
                'sandbox_data' => [
                    'public_key' => config('services.stripe.key'),
                    'secret_key' => config('services.stripe.secret'),
                ],
                'is_active' => true,
            ],
            [
                'sort_order' => 2,
                'name' => 'Crypto',
                'slug' => 'crypto',
                'icon' => null,
                'live_data' => [
                    'api_key' => config('services.crypto.api_key', 'api_key_value'),
                ],
                'sandbox_data' => [
                    'api_key' => config('services.crypto.api_key', 'api_key_value'),
                ],
                'is_active' => true,
            ],
            [
                'sort_order' => 3,
                'name' => 'Wallet',
                'slug' => 'wallet',
                'icon' => null,
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
