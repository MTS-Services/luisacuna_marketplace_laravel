<?php

namespace App\Exports;

use App\Models\GameConfig;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ArrayExport implements FromArray, WithHeadings, WithMapping
{
    protected $game;
    protected $platforms;
    protected $categories;
    protected $configs;

    public function __construct($game, $platforms, $categories)
    {
        $this->game = $game;
        $this->platforms = $platforms;
        $this->categories = $categories;

        // Preload configs
        $this->configs = GameConfig::where('game_id', $this->game->id)->get();
    }

    /**
     * Numeric array for Excel
     */
    public function array(): array
    {
        // We'll return **1 row** as example
        $deliveryMethods = $this->game->gameConfig->first()->delivery_methods ?? [];

        $row = [
            '100 Gold Package',
            'Instant delivery product',
            1,
            9.99,
            implode(' / ', $deliveryMethods),
            '', // delivery time can be added if needed
            $this->platforms,
            $this->categories
        ];

        // Add dynamic config columns
        foreach ($this->configs as $config) {
            if ($config->input_type === 'select') {
                $row[] = implode(' / ', json_decode($config->options, true) ?? []);
            } else {
                $row[] = 'Enter value';
            }
        }

        return [$row];
    }

    /**
     * Column headers
     */
    public function headings(): array
    {
        $headers = [
            'Product Title',
            'Description',
            'Quantity',
            'Price',
            'Delivery Method',
            'Delivery Time',
            'Platform',
            'Category',
        ];

        foreach ($this->configs as $config) {
            if ($config->field_name) {
                $headers[] = $config->field_name;
            }
        }

        return $headers;
    }

    /**
     * Mapping ensures row matches headers
     */
    public function map($row): array
    {
        return $row;
    }
}
