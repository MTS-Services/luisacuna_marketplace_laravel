<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\KycFormField;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KycFormFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KycFormField::insert([
            [
                'sort_order' => 1,
                'section_id' => 1,
                'field_key' => 'first_name',
                'label' => 'First Name',
                'input_type' => 'text',
                'is_required' => true,
                'validation_rules' => json_encode(['min' => 2, 'max' => 50]),
                'options' => null,
                'example' => 'John',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'section_id' => 1,
                'field_key' => 'last_name',
                'label' => 'Last Name',
                'input_type' => 'text',
                'is_required' => true,
                'validation_rules' => json_encode(['min' => 2, 'max' => 50]),
                'options' => null,
                'example' => 'Doe',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'section_id' => 2,
                'field_key' => 'identity_document_type',
                'label' => 'Document Type',
                'input_type' => 'select',
                'is_required' => true,
                'validation_rules' => null,
                'options' => json_encode(['Passport', 'National ID', 'Driver License']),
                'example' => 'Passport',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
