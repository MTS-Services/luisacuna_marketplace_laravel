<?php

namespace App\DTOs\Language;

use App\Enums\LanguageStatus;
use App\Enums\LanguageDirection;

class CreateLanguageDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $locale,
        public readonly string $name,
        public readonly ?string $native_name = null,
        public readonly LanguageStatus $status = LanguageStatus::ACTIVE,
        public readonly bool $is_active = false,
        public readonly LanguageDirection $default_direction = LanguageDirection::LTR,
    )
    {}
    public static function fromArray(array $data): self
    {
        return new self(
            locale: $data['locale'],
            name: $data['name'],
            native_name: $data['native_name'] ?? null,
            status: isset($data['status']) ? LanguageStatus::from($data['status']) : LanguageStatus::ACTIVE,
            is_active: $data['is_active'] ?? false,
            default_direction: isset($data['default_direction']) ? LanguageDirection::from($data['default_direction']) : LanguageDirection::LTR,
        );
    }

    public static function fromRequest($request): self
    {
        return self::fromArray($request->all());
    }
    public function toArray(): array
    {
        return [
            'locale' => $this->locale,
            'name' => $this->name,
            'native_name' => $this->native_name,
            'status' => $this->status->value,
            'is_active' => $this->is_active,
            'default_direction' => $this->default_direction->value,
        ];
    }
}
