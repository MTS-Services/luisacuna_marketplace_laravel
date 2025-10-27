<?php

namespace Database\Seeders;

use App\Livewire\Backend\Admin\Components\UserManagement\User\Profile\Referral;
use App\Models\Admin;
use App\Models\GameCategory;
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
            EmailTemplateSeeder::class,
            ReferralSettingSeeder::class,
            UserSeeder::class,
            GameCategorySeeder::class,
            GameSeeder::class,

            SellerProfileSeeder::class,
            UserStatisticsSeeder::class,
            ReferraSettingSeeder::class,
            UserReferralSeeder::class,
            KycSettingSeeder::class,
            CountryKycSettingSeeder::class,
            KycFormSectionSeeder::class,
            KycFormFieldSeeder::class,
            SubmittedKycSeeder::class,
            
        ]);

        // Admin::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@dev.com',
        //     'password' => 'admin@dev.com',
        //     'email_verified_at' => now(),
        // ]);
    }
}
