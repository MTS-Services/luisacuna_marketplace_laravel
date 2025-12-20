<?php
 
namespace App\Enums;
 
enum ConversationStatus: string
{
    case ACTIVE = 'active';
    case ARCHIVED = 'archived';
    case INACTIVE = 'inactive';
 
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::ARCHIVED => 'Archived',
            self::INACTIVE => 'Inactive',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'badge badge-success',
            self::ARCHIVED => 'badge badge-secondary',
            self::INACTIVE => 'badge badge-danger',
        };
    }
 
    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}