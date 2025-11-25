<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use App\Enums\UserStatus;
use Illuminate\Support\Str;
use App\Enums\userKycStatus;
use Illuminate\Database\Seeder;
use App\Enums\UserAccountStatus;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'sort_order' => 1,
            'country_id' => 1,
            'username' => 'user',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'avatar' => null,
            'date_of_birth' => '1990-01-01',
            'timezone' => 'UTC',
            'language_id' => 1,
            'currency_id' => 1,
            // 'kyc_status' => userKycStatus::PENDING->value,
            'email' => "user@dev.com",
            'email_verified_at' => now(),
            'password' => Hash::make("user@dev.com"),
            'phone' => '1234567890',
            'phone_verified_at' => now(),
            'user_type' => UserType::BUYER->value,
            'account_status' => UserAccountStatus::ACTIVE->value,
            'last_login_at' => now(),
            'last_login_ip' => '127.0.0.1',
            'login_attempts' => 0,
            'locked_until' => null,
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'terms_accepted_at' => now(),
            'privacy_accepted_at' => now(),
            'last_synced_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create 5 dummy users using fake() helper
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'sort_order' => $i,
                'country_id' => 1,
                'username' => fake()->unique()->userName,
                'first_name' => fake()->firstName,
                'last_name' => fake()->lastName,
                'avatar' => null,
                'date_of_birth' => fake()->date(),
                'timezone' => fake()->timezone,
                'email' => "user@dev{$i}.com",
                'email_verified_at' => null,
                'password' => Hash::make("user@dev{$i}.com"),
                'phone' => fake()->phoneNumber,
                'phone_verified_at' => now(),
                'user_type' => UserType::SELLER->value,
                'account_status' => UserAccountStatus::PENDING_VERIFICATION->value,
                'language_id' => 1,
                'currency_id' => 1,
                // 'kyc_status' => userKycStatus::PENDING->value,
                'last_login_at' => now(),
                'last_login_ip' => fake()->ipv4,
                'login_attempts' => 0,
                'locked_until' => null,
                'two_factor_enabled' => false,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'terms_accepted_at' => now(),
                'privacy_accepted_at' => now(),
                'last_synced_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}