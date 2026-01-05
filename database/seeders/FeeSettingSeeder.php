<?php

namespace Database\Seeders;

use App\Enums\FeeSettingStatus;
use App\Models\FeeSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeeSettings::create([
            'buyer_fee' => 10,
            'seller_fee' => 10,
            'status' => FeeSettingStatus::ACTIVE,
        ]);
    }
}
