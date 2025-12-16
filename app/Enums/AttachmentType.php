<?php
 
namespace App\Enums;
 
enum AttachmentType: string
{
    case IMAGE = 'image';
    case DOCUMENT = 'document';
    case VIDEO = 'video';
    case AUDIO = 'audio';
 
    public function label(): string
    {
        return match($this) {
            self::IMAGE => 'Image',
            self::DOCUMENT => 'Document',
            self::VIDEO => 'Video',
            self::AUDIO => 'Audio',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::IMAGE => 'badge badge-success',
            self::DOCUMENT => 'badge badge-info',
            self::VIDEO => 'badge badge-warning',
            self::AUDIO => 'badge badge-danger',
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