<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use ParagonIE\Sodium\Core\Curve25519\H;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            ApplicationSettingSeeder::class,
            PaymentGatewaySeeder::class,
            WithdrawalGatewaySeeder::class,

            RoleSeeder::class,
            PermissionSeeder::class,
            CountrySeeder::class,
            AdminSeeder::class,
            RoleHasPermissionSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            // ExchangeRateSeeder::class,
            // ExchangeRateHistorySeeder::class,
            EmailTemplateSeeder::class,
            ReferralSettingSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ServerSeeder::class,
            PlatformSeeder::class,
            GameSeeder::class,
            GameCategorySeeder::class,
            TagSeeder::class,
            GameTagSeeder::class,

            SellerProfileSeeder::class,
            UserStatisticsSeeder::class,
            ReferraSettingSeeder::class,
            UserReferralSeeder::class,
            KycSettingSeeder::class,
            CountryKycSettingSeeder::class,
            KycFormSectionSeeder::class,
            KycFormFieldSeeder::class,
            SubmittedKycSeeder::class,
            PageViewSeeder::class,
            RankSeeder::class,
            UserRankSeeder::class,
            AchievementTypeSeeder::class,
            AchievementSeeder::class,

            DeliveryMethodSeeder::class,
            RaritySeeder::class,
            TypeSeeder::class,
            HeroSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
