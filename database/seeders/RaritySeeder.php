<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\Rarity;
    use App\Enums\RarityStatus;

    class RaritySeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {

            Rarity::insert([
                'name' => 'Common',
                'status' => RarityStatus::ACTIVE->value,
                'icon' => 'common.png',
            ],

            [
                'name' => 'Rare',
                'status' => RarityStatus::ACTIVE->value,
                'icon' => 'common.png',
            ],
            
            [
                'name' => 'Epic',
                'status' => RarityStatus::ACTIVE->value,
                'icon' => 'common.png',
            ]);
        }
}
