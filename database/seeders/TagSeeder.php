<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Enums\TagStatus;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Popular',
                'slug' => 'popular',
                'status' => TagStatus::ACTIVE->value,
                'text_color' => '#FFFFFF',
                'bg_color' => '#FF5733',
            ],
            [
                'name' => 'New Release',
                'slug' => 'new-release',
                'status' => TagStatus::ACTIVE->value,
                'text_color' => '#000000',
                'bg_color' => '#FFD700',
            ],
            [
                'name' => 'Trending',
                'slug' => 'trending',
                'status' => TagStatus::ACTIVE->value,
                'text_color' => '#FFFFFF',
                'bg_color' => '#28A745',
            ],
        ];

        foreach ($tags as $item) {
            Tag::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
