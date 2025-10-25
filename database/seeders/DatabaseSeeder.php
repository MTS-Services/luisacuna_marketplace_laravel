<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          $this->call([
            CountrySeeder::class,
            AdminSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            ExchangeRateSeeder::class,
            ExchangeRateHistorySeeder::class,
            EmialTemplateSeeder::class,
            ReferralSettingSeeder::class,
            UserSeeder::class,
            SellerProfileSeeder::class,
            UserStatisticsSeeder::class,
            UserReferralSeeder::class,
            
        ]);

        // Admin::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@dev.com',
        //     'password' => 'admin@dev.com',
        //     'email_verified_at' => now(),
        // ]);
    }
}
