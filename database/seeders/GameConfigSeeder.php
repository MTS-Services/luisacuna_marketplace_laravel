<?php

namespace Database\Seeders;

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use App\Enums\GameDeliveryMethod;
use App\Models\GameConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Game One
        GameConfig::create([
            'game_id' => 1,
            'category_id' => 1,
            'field_name' => 'Server',
            'slug' => 'server',
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN,
            'dropdown_values' => json_encode(['Asia', 'Europe', 'North America', 'South America', 'Oceania']),
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);
        GameConfig::create([
            'game_id' => 1,
            'category_id' => 1,
            'field_name' => 'Faction',
            'slug' => 'faction',
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN,
            'dropdown_values' => json_encode(['Horde', 'Alliance', 'Neutral']),
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);
        GameConfig::create([
            'game_id' => 1,
            'category_id' => 1,
            'field_name' => 'Number of Skin',
            'slug' => 'number-of-skin',
            'filter_type' => GameConfigFilterType::FILTER_BY_RANGE,
            'input_type' => GameConfigInputType::NUMBER,
            'dropdown_values' => null,
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);
        GameConfig::create([
            'game_id' => 1,
            'category_id' => 1,
            'field_name' => 'Rare Skin',
            'slug' => 'rare-skin',
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN,
            'dropdown_values' => json_encode(['Black Knight', 'Ikonic', 'Galaxy']),
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);

        // Config Game Two

        GameConfig::create([
            'game_id' => 2,
            'category_id' => 1,
            'field_name' => 'Server',
            'slug' => 'server',
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN,
            'dropdown_values' => json_encode(['Singpore', 'Russian']),
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);
        GameConfig::create([
            'game_id' => 2,
            'category_id' => 1,
            'field_name' => 'Faction',
            'slug' => 'faction',
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN,
            'dropdown_values' => json_encode(['Livik', 'Pochonki', 'Port']),
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);
        GameConfig::create([
            'game_id' => 2,
            'category_id' => 1,
            'field_name' => 'Number of Skin',
            'slug' => 'number-of-skin',
            'filter_type' => GameConfigFilterType::FILTER_BY_RANGE,
            'input_type' => GameConfigInputType::NUMBER,
            'dropdown_values' => null,
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);
        GameConfig::create([
            'game_id' => 2,
            'category_id' => 1,
            'field_name' => 'Rare Skin',
            'slug' => 'rare-skin',
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN,
            'dropdown_values' => json_encode(['Green Light', 'Green Gray', 'Black Diamond']),
            'delivery_methods' => json_encode(GameDeliveryMethod::options())
        ]);

    }
}
