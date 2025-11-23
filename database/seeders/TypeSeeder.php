<?php

namespace Database\Seeders;

use App\Enums\TypeStatus;
use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Type::insert(
            [
                'name' => 'Type-1',
                'status' => TypeStatus::ACTIVE->value,
                'icon' => 'common.png',
            ],

            [
                'name' => 'Type-2',
                'status' => TypeStatus::ACTIVE->value,
                'icon' => 'common.png',
            ],

            [
                'name' => 'Type-3',
                'status' => TypeStatus::ACTIVE->value,
                'icon' => 'common.png',
            ]
        );
    }
}
