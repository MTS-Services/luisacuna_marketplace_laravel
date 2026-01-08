<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawalSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed withdrawal methods
        DB::table('withdrawal_methods')->insert([
            [
                'name' => 'Payoneer',
                'code' => 'payoneer',
                'description' => 'Fast and secure payments via Payoneer',
                'min_amount' => 50.00,
                'max_amount' => 50000.00,
                'processing_time' => '1-3 business days',
                'fee_type' => 'percentage',
                'fee_amount' => 0.00,
                'fee_percentage' => 2.00,
                'is_active' => true,
                'display_order' => 1,
                'required_fields' => json_encode(['email']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Transfer',
                'code' => 'bank_transfer',
                'description' => 'Direct bank transfer',
                'min_amount' => 100.00,
                'max_amount' => null,
                'processing_time' => '3-5 business days',
                'fee_type' => 'fixed',
                'fee_amount' => 5.00,
                'fee_percentage' => 0.00,
                'is_active' => true,
                'display_order' => 2,
                'required_fields' => json_encode(['account_number', 'bank_name', 'account_holder', 'routing_number']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Credit/Debit Card',
                'code' => 'card',
                'description' => 'Withdraw to your card',
                'min_amount' => 20.00,
                'max_amount' => 10000.00,
                'processing_time' => '1-2 business days',
                'fee_type' => 'percentage',
                'fee_amount' => 0.00,
                'fee_percentage' => 2.50,
                'is_active' => true,
                'display_order' => 3,
                'required_fields' => json_encode(['card_number', 'card_holder', 'expiry_date']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PayPal',
                'code' => 'paypal',
                'description' => 'Instant PayPal withdrawal',
                'min_amount' => 10.00,
                'max_amount' => 25000.00,
                'processing_time' => 'Instant',
                'fee_type' => 'mixed',
                'fee_amount' => 1.00,
                'fee_percentage' => 2.00,
                'is_active' => true,
                'display_order' => 4,
                'required_fields' => json_encode(['email']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed withdrawal settings
        DB::table('withdrawal_settings')->insert([
            [
                'setting_key' => 'min_balance_required',
                'setting_value' => '50.00',
                'setting_type' => 'number',
                'description' => 'Minimum account balance required to withdraw',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'auto_approval_limit',
                'setting_value' => '1000.00',
                'setting_type' => 'number',
                'description' => 'Auto-approve withdrawals below this amount',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'require_verification',
                'setting_value' => 'true',
                'setting_type' => 'boolean',
                'description' => 'Require identity verification before withdrawal',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'business_days_only',
                'setting_value' => 'true',
                'setting_type' => 'boolean',
                'description' => 'Process withdrawals on business days only',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'max_pending_requests',
                'setting_value' => '3',
                'setting_type' => 'number',
                'description' => 'Maximum pending withdrawal requests per user',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
