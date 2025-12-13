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
                'image' => 'https://placehold.co/400x400/ff0000/ffffff?text=Manual+Delivery',
            ],
            [
                'name' => 'instant Delivery',
                'slug' => 'instant-delivery',
                'image' => 'https://placehold.co/400x400/00ff00/ffffff?text=Instant+Delivery',
            ],
        ]);
    }
}
