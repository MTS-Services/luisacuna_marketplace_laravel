<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Enums\LanguageStatus;
use Illuminate\Database\Seeder;
use App\Enums\LanguageDirection;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            [
                'sort_order'   => 1,
                'locale'       => 'en',
                'name'         => 'English',
                'native_name'  => 'English',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => true,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'en',
                'flag_icon'    => 'us.svg',
            ],
            [
                'sort_order'   => 2,
                'locale'       => 'fr',
                'name'         => 'French',
                'native_name'  => 'Français',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'fr',
                'flag_icon'    => 'fr.svg',
            ],
            [
                'sort_order'   => 3,
                'locale'       => 'de',
                'name'         => 'German',
                'native_name'  => 'Deutsch',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'de',
                'flag_icon'    => 'de.svg',
            ],
            [
                'sort_order'   => 4,
                'locale'       => 'es',
                'name'         => 'Spanish',
                'native_name'  => 'Español',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'es',
                'flag_icon'    => 'es.svg',
            ],
            [
                'sort_order'   => 5,
                'locale'       => 'jp',
                'name'         => 'Japanese',
                'native_name'  => '日本語',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'jp',
                'flag_icon'    => 'jp.svg',
            ],
            [
                'sort_order'   => 6,
                'locale'       => 'it',
                'name'         => 'Italian',
                'native_name'  => 'Italiano',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'it',
                'flag_icon'    => 'it.svg',
            ],
            [
                'sort_order'   => 7,
                'locale'       => 'id',
                'name'         => 'Bahasa',
                'native_name'  => 'Bahasa',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'id',
                'flag_icon'    => 'id.svg',
            ],
            [
                'sort_order'   => 8,
                'locale'       => 'br',
                'name'         => 'Português',
                'native_name'  => 'Português',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_default'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'country_code' => 'br',
                'flag_icon'    => 'br.svg',
            ]
        ]);
    }
}
