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

            ApplicationSettingSeeder::class,
            PaymentGatewaySeeder::class,
            // WithdrawalGatewaySeeder::class,
            WithdrawalMethodSeeder::class,

            RoleSeeder::class,
            PermissionSeeder::class,
            CountrySeeder::class,
            AdminSeeder::class,
            RoleHasPermissionSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            EmailTemplateSeeder::class,
            ReferralSettingSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            GameSeeder::class,
            PlatformSeeder::class,
            GameCategorySeeder::class,
            TagSeeder::class,
            GameTagSeeder::class,

            // SellerProfileSeeder::class,
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
            HeroSeeder::class,
            ProductSeeder::class,
            FaqSeeder::class,
            GameConfigSeeder::class,
            FeeSettingSeeder::class,

            ProductSeeder::class,
            WalletSeeder::class,
        ]);
    }
}
