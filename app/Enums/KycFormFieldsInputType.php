<?php

namespace App\Enums;

enum KycFormFieldsInputType: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case TEL = 'tel';
    case DATE = 'date';
    case DATETIME_LOCAL = 'datetime-local';
    case TIME = 'time';
    case URL = 'url';
    case SINGLE_FILE = 'single_file';
    case MULTIPLE_FILE = 'multiple_file';
    case SINGLE_IMAGE = 'single_image';
    case MULTIPLE_IMAGE = 'multiple_image';
    case SINGLE_SELECT = 'single_select';
    case MULTIPLE_SELECT = 'multiple_select';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case RANGE = 'range';
    case COLOR = 'color';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => __('text'),
            self::NUMBER => __('number'),
            self::EMAIL => __('email'),
            self::PASSWORD => __('password'),
            self::TEL => __('tel'),
            self::DATE => __('date'),
            self::DATETIME_LOCAL => __('datetime-local'),
            self::TIME => __('time'),
            self::URL => __('url'),
            self::SINGLE_FILE => __('single_file'),
            self::MULTIPLE_FILE => __('multiple_file'),
            self::SINGLE_IMAGE => __('single_image'),
            self::MULTIPLE_IMAGE => __('multiple_image'),
            self::SINGLE_SELECT => __('single_select'),
            self::MULTIPLE_SELECT => __('multiple_select'),
            self::RADIO => __('radio'),
            self::CHECKBOX => __('checkbox'),
            self::RANGE => __('range'),
            self::COLOR => __('color'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TEXT => 'badge badge-primary',
            self::NUMBER => 'badge badge-secondary',
            self::EMAIL => 'badge badge-accent',
            self::PASSWORD => 'badge badge-warning',
            self::TEL => 'badge badge-neutral',
            self::DATE => 'badge badge-info',
            self::DATETIME_LOCAL => 'badge badge-success',
            self::TIME => 'badge badge-warning',
            self::URL => 'badge badge-error',
            self::SINGLE_FILE => 'badge bg-violet-500 text-white',
            self::MULTIPLE_FILE => 'badge bg-fuchsia-500 text-white',
            self::SINGLE_IMAGE => 'badge bg-cyan-500 text-white',
            self::MULTIPLE_IMAGE => 'badge bg-teal-500 text-white',
            self::SINGLE_SELECT => 'badge bg-amber-500 text-white',
            self::MULTIPLE_SELECT => 'badge bg-emerald-500 text-white',
            self::RADIO => 'badge bg-sky-500 text-white',
            self::CHECKBOX => 'badge bg-indigo-500 text-white',
            self::RANGE => 'badge bg-pink-500 text-white',
            self::COLOR => 'badge bg-rose-500 text-white',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
