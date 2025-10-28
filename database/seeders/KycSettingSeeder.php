<?php

namespace Database\Seeders;

use App\Models\KycSetting;
use Illuminate\Support\Carbon;
use App\Enums\KycSettingStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KycSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KycSetting::insert([
            [
                'sort_order' => 1,
                'type' => 'personal_info',
                'status' => KycSettingStatus::ACTIVE->value,
                'version' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'type' => 'identity_document',
                'status' => KycSettingStatus::ACTIVE->value,
                'version' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'type' => 'address_verification',
                'status' => KycSettingStatus::ACTIVE->value,
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
