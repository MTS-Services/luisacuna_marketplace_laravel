<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\CountryKycSetting;
use App\Enums\CountryKycSettingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountryKycSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CountryKycSetting::insert([
            [
                'sort_order' => 1,
                'kyc_setting_id' => 1,
                'country_id' => 1,
                'type' => 'personal_info',
                'status' => CountryKycSettingStatus::ACTIVE->value,
                'version' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'kyc_setting_id' => 2,
                'country_id' => 1,
                'type' => 'identity_document',
                'status' => CountryKycSettingStatus::ACTIVE->value,
                'version' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'kyc_setting_id' => 3,
                'country_id' => 2,
                'type' => 'address_verification',
                'status' => CountryKycSettingStatus::ACTIVE->value,
                'version' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
