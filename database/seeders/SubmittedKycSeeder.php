<?php

namespace Database\Seeders;

use App\Models\SubmittedKyc;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubmittedKycSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubmittedKyc::insert([
            [
                'sort_order' => 1,
                'kyc_setting_id' => 1,
                'ckyc_setting_id' => 1,
                'version' => 1,
                'type' => 'individual',
                'status' => 'pending',
                'submitted_data' => json_encode([
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'dob' => '1990-01-01',
                    'document_type' => 'Passport',
                    'document_number' => 'A1234567'
                ]),
                'note' => 'Initial submission.',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'kyc_setting_id' => 1,
                'ckyc_setting_id' => 1,
                'version' => 1,
                'type' => 'individual',
                'status' => 'approved',
                'submitted_data' => json_encode([
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'dob' => '1992-05-15',
                    'document_type' => 'National ID',
                    'document_number' => 'NID123456'
                ]),
                'note' => 'Verified by admin.',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
