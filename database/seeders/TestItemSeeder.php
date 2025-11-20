<?php

namespace Database\Seeders;

use App\Models\TestItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TestItem::insert([
            [
                'name' => 'Item 1',
                'slug' => 'item-1',
                'price' => 10.99
            ],
            [
                'name' => 'Item 2',
                'slug' => 'item-2',
                'price' => 19.99
            ],
            [
                'name' => 'Item 3',
                'slug' => 'item-3',
                'price' => 29.99
            ]
        ]);
    }
}
