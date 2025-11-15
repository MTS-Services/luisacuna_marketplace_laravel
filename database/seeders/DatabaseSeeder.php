<?php

namespace Database\Seeders;

use App\Models\Admin;

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
            RoleSeeder::class,
            PermissionSeeder::class,
            CountrySeeder::class,
            AdminSeeder::class,
            RoleHasPermissionSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            ExchangeRateSeeder::class,
            ExchangeRateHistorySeeder::class,
            EmailTemplateSeeder::class,
            ReferralSettingSeeder::class,
            UserSeeder::class,
            GamePlatformSeeder::class,
            CategorySeeder::class,
            GameSeeder::class,
            ApplicationSettingSeeder::class,

            SellerProfileSeeder::class,
            UserStatisticsSeeder::class,
            ReferraSettingSeeder::class,
            UserReferralSeeder::class,
            KycSettingSeeder::class,
            CountryKycSettingSeeder::class,
            KycFormSectionSeeder::class,
            KycFormFieldSeeder::class,
            SubmittedKycSeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
            PageViewSeeder::class,
            RankSeeder::class,
            AchievementSeeder::class,
        ]);

        // Admin::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@dev.com',
        //     'password' => 'admin@dev.com',
        //     'email_verified_at' => now(),
        // ]);
    }
}
