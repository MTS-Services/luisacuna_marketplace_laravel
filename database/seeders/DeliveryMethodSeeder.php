<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryMethod::insert([
            [
                'name' => 'Manual Delivery',
                'slug' => 'manual-delivery',
                'image' => 'ffffff_aa0hbl',
            ],
            [
                'name' => 'instant Delivery',
                'slug' => 'instant-delivery',
                'image' => 'ffffff_1_jhvgjk',
            ],
        ]);
    }
}
