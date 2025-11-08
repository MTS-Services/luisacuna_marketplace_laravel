<?php

namespace Database\Seeders;

use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class SellerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all valid IDs from related tables
        $userIds = User::pluck('id')->toArray();
        $countryIds = Country::pluck('id')->toArray();

        // If related tables are empty, stop seeding
        if (empty($userIds) || empty($countryIds)) {
            $this->command->warn('⚠️ Please seed Users and Countries tables first!');
            return;
        }

        $profiles = [
            [
                'sort_order' => 1,
                'user_id' => $faker->randomElement($userIds),
                'first_name' => 'John',
                'middle_name' => null,
                'last_name' => 'Doe',
                'date_of_birth' => '1990-05-14',
                'nationality' => 'American',
                'street_address' => '123 Main Street',
                'city' => 'New York',
                'country_id' => $faker->randomElement($countryIds),
                'postal_code' => '10001',
                'is_experienced_seller' => true,
                'identification' => 'id_card_john.jpg',
                'selfie' => 'selfie_john.jpg',
                'id_verified' => true,
                'id_verified_at' => Carbon::now(),
                'seller_verified' => true,
                'seller_verified_at' => Carbon::now(),
                'seller_level' => 'bronze',
                'commission_rate' => 10.00,
                'minimum_payout' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'user_id' => $faker->randomElement($userIds),
                'first_name' => 'Emily',
                'middle_name' => 'Rose',
                'last_name' => 'Smith',
                'date_of_birth' => '1995-09-22',
                'nationality' => 'British',
                'street_address' => '45 Oxford Street',
                'city' => 'London',
                'country_id' => $faker->randomElement($countryIds),
                'postal_code' => 'W1D 2LT',
                'is_experienced_seller' => false,
                'identification' => 'passport_emily.jpg',
                'selfie' => 'selfie_emily.jpg',
                'id_verified' => false,
                'id_verified_at' => null,
                'seller_verified' => false,
                'seller_verified_at' => null,
                'seller_level' => 'bronze',
                'commission_rate' => 10.00,
                'minimum_payout' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Generate random extra demo profiles
        for ($i = 3; $i <= 10; $i++) {
            $profiles[] = [
                'sort_order' => $i,
                'user_id' => $faker->randomElement($userIds),
                'first_name' => $faker->firstName,
                'middle_name' => $faker->optional()->firstName,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d', '2000-01-01'),
                'nationality' => $faker->country,
                'street_address' => $faker->address,
                'city' => $faker->city,
                'country_id' => $faker->randomElement($countryIds),
                'postal_code' => $faker->postcode,
                'is_experienced_seller' => $faker->boolean(),
                'identification' => $faker->word . '_id.jpg',
                'selfie' => $faker->word . '_selfie.jpg',
                'id_verified' => $faker->boolean(),
                'id_verified_at' => $faker->boolean() ? Carbon::now() : null,
                'seller_verified' => $faker->boolean(),
                'seller_verified_at' => $faker->boolean() ? Carbon::now() : null,
                'seller_level' => 'bronze',
                'commission_rate' => 10.00,
                'minimum_payout' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        SellerProfile::insert($profiles);

        $this->command->info('✅ Seller profiles seeded successfully!');
    }
}
