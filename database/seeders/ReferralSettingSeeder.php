<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use App\Models\ReferralSetting;
use Illuminate\Database\Seeder;
use App\Enums\ReferralSettingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReferralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReferralSetting::insert([
            [
                'sort_order' => 1,
                'status' => ReferralSettingStatus::ACTIVE->value,
                'title' => 'Standard Referral',
                'description' => 'Give bonus to referrer and referred user',
                'referrer_bonus' => 10.00,
                'referred_bonus' => 5.00,
                'max_referrals_per_user' => 10,
                'expiry_days' => 30,
                'currency_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'status' => ReferralSettingStatus::ACTIVE->value,
                'title' => 'Premium Referral',
                'description' => 'Higher bonus for premium users',
                'referrer_bonus' => 20.00,
                'referred_bonus' => 10.00,
                'max_referrals_per_user' => 20,
                'expiry_days' => 60,
                'currency_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
