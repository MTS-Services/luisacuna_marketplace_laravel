<?php

namespace App\Services;

use App\Models\FeeSettings;
use App\Enums\FeeSettingStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeeSettingsService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getActiveFee()
    {
        return FeeSettings::where('status', FeeSettingStatus::ACTIVE)->first();
    }

    public function createFeeSetting(array $data)
    {
        return DB::transaction(function () use ($data) {
            FeeSettings::where('status', FeeSettingStatus::ACTIVE)
                ->update(['status' => FeeSettingStatus::INACTIVE]);

            $lastOrder = FeeSettings::max('sort_order') ?? 0;
            $nextOrder = $lastOrder + 1;

            return FeeSettings::create([
                'seller_fee' => $data['seller_fee'],
                'buyer_fee'  => $data['buyer_fee'],
                'status'     => FeeSettingStatus::ACTIVE,
                'sort_order' => $nextOrder,
                'updated_by' => $data['updated_by'] ?? null,
            ]);
        });
    }
}
