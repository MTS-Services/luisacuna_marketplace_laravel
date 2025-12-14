<?php

namespace Database\Seeders;

use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SellerProfileSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $countryIds = Country::pluck('id')->toArray();

        if (empty($userIds) || empty($countryIds)) {
            $this->command->warn('⚠️ Please seed Users and Countries tables first!');
            return;
        }

        $getSafeUserId = function ($index) use ($userIds) {
            return $userIds[($index - 1) % count($userIds)];
        };

        $getSafeCountryId = function ($index) use ($countryIds) {
            return $countryIds[($index - 1) % count($countryIds)];
        };

        $profiles = [
            [
                'sort_order' => 1,
                'user_id' => $getSafeUserId(1),
                'first_name' => 'Alice',
                'middle_name' => null,
                'last_name' => 'Johnson',
                'date_of_birth' => '1985-01-15',
                'nationality' => 'Canadian',
                'street_address' => '45 Queen St',
                'city' => 'Toronto',
                'country_id' => $getSafeCountryId(1),
                'postal_code' => 'M5H 2M9',
                'is_experienced_seller' => true,
                'identification' => 'id_card_alice.jpg',
                'selfie' => 'selfie_alice.jpg',
                'id_verified' => true,
                'id_verified_at' => Carbon::now()->subDays(5),
                'seller_verified' => true,
                'seller_verified_at' => Carbon::now()->subDays(5),
                'seller_level' => 'gold',
                'commission_rate' => 8.00,
                'minimum_payout' => 100.00,
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'sort_order' => 2,
                'user_id' => $getSafeUserId(2),
                'first_name' => 'David',
                'middle_name' => 'Michael',
                'last_name' => 'Lee',
                'date_of_birth' => '1992-11-28',
                'nationality' => 'Australian',
                'street_address' => '789 George Street',
                'city' => 'Sydney',
                'country_id' => $getSafeCountryId(2),
                'postal_code' => '2000',
                'is_experienced_seller' => false,
                'identification' => 'passport_david.jpg',
                'selfie' => 'selfie_david.jpg',
                'id_verified' => true,
                'id_verified_at' => Carbon::now()->subDay(),
                'seller_verified' => false,
                'seller_verified_at' => null,
                'seller_level' => 'bronze',
                'commission_rate' => 10.00,
                'minimum_payout' => 50.00,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'sort_order' => 3,
                'user_id' => $getSafeUserId(3),
                'first_name' => 'Maria',
                'middle_name' => null,
                'last_name' => 'Garcia',
                'date_of_birth' => '2001-03-01',
                'nationality' => 'Mexican',
                'street_address' => 'Av. Insurgentes 345',
                'city' => 'Mexico City',
                'country_id' => $getSafeCountryId(3),
                'postal_code' => '06700',
                'is_experienced_seller' => true,
                'identification' => 'driver_license_maria.jpg',
                'selfie' => 'selfie_maria.jpg',
                'id_verified' => true,
                'id_verified_at' => Carbon::now()->subMonths(1),
                'seller_verified' => true,
                'seller_verified_at' => Carbon::now()->subMonths(1)->addHours(2),
                'seller_level' => 'silver',
                'commission_rate' => 9.00,
                'minimum_payout' => 75.00,
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subDays(20),
            ],
        ];

        $randomNames = ['Chris', 'Taylor', 'Jordan', 'Alex', 'Riley', 'Jamie', 'Morgan'];
        $randomLastNames = ['Brown', 'Miller', 'Wilson', 'Moore', 'Taylor', 'Anderson'];
        $randomCities = ['Miami', 'Berlin', 'Paris', 'Tokyo', 'Dubai', 'Seoul'];

        for ($i = 4; $i <= 10; $i++) {
            $isExperienced = (bool)($i % 2);
            $isVerified = (bool)($i % 3 == 0);
            $level = ($i % 4 == 0) ? 'gold' : (($i % 2 == 0) ? 'silver' : 'bronze');

            $profiles[] = [
                'sort_order' => $i,
                'user_id' => $getSafeUserId($i),
                'first_name' => $randomNames[array_rand($randomNames)],
                'middle_name' => ($i % 5 == 0) ? $randomNames[array_rand($randomNames)] : null,
                'last_name' => $randomLastNames[array_rand($randomLastNames)],
                'date_of_birth' => Carbon::now()->subYears(rand(20, 40))->subDays(rand(0, 365))->format('Y-m-d'),
                'nationality' => 'Generic',
                'street_address' => rand(100, 999) . ' Random Road',
                'city' => $randomCities[array_rand($randomCities)],
                'country_id' => $getSafeCountryId($i),
                'postal_code' => rand(10000, 99999),
                'is_experienced_seller' => $isExperienced,
                'identification' => 'random_id_' . $i . '.jpg',
                'selfie' => 'random_selfie_' . $i . '.jpg',
                'id_verified' => $isVerified,
                'id_verified_at' => $isVerified ? Carbon::now()->subDays(rand(1, 60)) : null,
                'seller_verified' => $isVerified,
                'seller_verified_at' => $isVerified ? Carbon::now()->subDays(rand(1, 60))->addHours(1) : null,
                'seller_level' => $level,
                'commission_rate' => ($level == 'gold') ? 8.00 : (($level == 'silver') ? 9.00 : 10.00),
                'minimum_payout' => ($level == 'gold') ? 100.00 : (($level == 'silver') ? 75.00 : 50.00),
                'created_at' => Carbon::now()->subMonths(rand(1, 12)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        SellerProfile::insert($profiles);

        $this->command->info('✅ Seller profiles seeded successfully!');
    }
}
