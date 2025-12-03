<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Platform::factory(10)->create();
        // Xbox, Xbox One, Xbox Series S, Xbox Series X, PlayStation 1, PlayStation 2, PlayStation 3, PlayStation 4, PlayStation 5, Nintendo, PC, Mobile, iOS, Android, Windows, Linux, Other
        Platform::insert([
            [
                'name' => 'XBox',
            ],
            [
                'name' => 'XBox One',
            ],
            [
                'name' => 'XBox Series S',
            ],
            [
                'name' => 'XBox Series X',
            ],
            [
                'name' => 'PlayStation 1',
            ],
            [
                'name' => 'PlayStation 2',
            ],
            [
                'name' => 'PlayStation 3',
            ],
            [
                'name' => 'PlayStation 4',
            ],
            [
                'name' => 'PlayStation 5',
            ],
            [
                'name' => 'Nintendo',
            ],
            [
                'name' => 'PC',
            ],
            [
                'name' => 'Mobile',
            ],
            [
                'name' => 'iOS',
            ],
            [
                'name' => 'Android',
            ],
            [
                'name' => 'Windows',
            ],
            [
                'name' => 'Linux',
            ],
            [
                'name' => 'Other',
            ],
        ]);
    }
}
