<?php

namespace Database\Seeders;

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
            CategorySeeder::class,
            ServerSeeder::class,
            PlatformSeeder::class,
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
            UserRankSeeder::class,
            AchievementTypeSeeder::class,
            AchievementSeeder::class,

            DeliveryMethodSeeder::class,
            OfferItemSeeder::class,
            // GameServerSeeder::class,
            // DeliveryMethodSeeder::class,
            // OfferItemSeeder::class,
        ]);
    }
}
