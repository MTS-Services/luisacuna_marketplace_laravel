<?php

namespace Database\Seeders;

use App\Models\KycFormSection;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KycFormSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KycFormSection::insert([
            [
                'sort_order' => 1,
                'kyc_setting_id' => 1,
                'kyc_setting_type' => 'personal_info',
                'title' => 'Basic Personal Information',
                'description' => 'User’s full name, date of birth and other personal details.',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'kyc_setting_id' => 1,
                'kyc_setting_type' => 'identity_document',
                'title' => 'Identity Documents',
                'description' => 'Upload government issued identity documents such as Passport, National ID.',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'kyc_setting_id' => 2,
                'kyc_setting_type' => 'address_verification',
                'title' => 'Address Verification',
                'description' => 'Provide proof of address like utility bills or bank statements.',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
