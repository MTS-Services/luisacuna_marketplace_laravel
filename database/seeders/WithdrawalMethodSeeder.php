<?php

namespace Database\Seeders;

use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WithdrawalMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('withdrawal_methods')->insert([
            [
                'sort_order'       => 1,
                'name'             => 'Payoneer',
                'code'             => 'payoneer',
                'description'      => 'Withdraw funds using Payoneer account',
                'icon'             => 'icons/payoneer.png',
                'status'           => ActiveInactiveEnum::ACTIVE,
                'min_amount'       => 50.00,
                'max_amount'       => 10000.00,
                'processing_time'  => '1-3 business days',
                'fee_type'         => WithdrawalFeeType::PERCENTAGE,
                'fee_amount'       => 0.00,
                'fee_percentage'   => 2.00,
                'required_fields'  => json_encode([
                    'payoneer_email' => 'required|email',
                ]),
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'sort_order'       => 2,
                'name'             => 'Bank Transfer',
                'code'             => 'bank_transfer',
                'description'      => 'Withdraw directly to your bank account',
                'icon'             => 'icons/bank.png',
                'status'           => ActiveInactiveEnum::ACTIVE,
                'min_amount'       => 100.00,
                'max_amount'       => null,
                'processing_time'  => '3-5 business days',
                'fee_type'         => WithdrawalFeeType::FIXED,
                'fee_amount'       => 5.00,
                'fee_percentage'   => 0.00,
                'required_fields'  => json_encode([
                    'account_name'   => 'required|string',
                    'account_number' => 'required|string',
                    'bank_name'      => 'required|string',
                ]),
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'sort_order'       => 3,
                'name'             => 'Card',
                'code'             => 'card',
                'description'      => 'Withdraw to debit or credit card',
                'icon'             => 'icons/card.png',
                'status'           => ActiveInactiveEnum::INACTIVE,
                'min_amount'       => 20.00,
                'max_amount'       => 5000.00,
                'processing_time'  => 'Instant - 24 hours',
                'fee_type'         => WithdrawalFeeType::FIXED,
                'fee_amount'       => 2.50,
                'fee_percentage'   => 0.00,
                'required_fields'  => json_encode([
                    'card_holder_name' => 'required|string',
                    'card_number'      => 'required|string',
                ]),
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}
