<?php 

namespace App\DTOs\Game;

use App\Enums\GameCategoryStatus;
use Illuminate\Support\Str;

class UpdateGameCategoryDTO
 {
        public function __construct(
        public readonly string $name,
        public readonly ?string $description ,
        public readonly GameCategoryStatus $status = GameCategoryStatus::ACTIVE
    )
    {
        
    }

    
    public static function formArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            status: isset($data['status']) ? GameCategoryStatus::from($data['status']) : GameCategoryStatus::ACTIVE,
            
        );
    }

    public static function formRequest($request): self
    {
        return self::formArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
            'slug' => Str::slug($this->name),
        ];
    }
}