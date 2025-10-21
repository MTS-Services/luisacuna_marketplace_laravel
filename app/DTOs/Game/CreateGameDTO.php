<?php 

namespace App\DTOs\Game;

use App\Enums\GameStatus;
use Illuminate\Support\Str;

class CreateGameDTO 
{
    public function __construct(
        protected readonly string $name,
        protected readonly string $slug,
        protected readonly int $game_category_id,
        protected readonly GameStatus $status = GameStatus::ACTIVE,
        protected readonly string $developer,
        protected readonly string $publisher,
        protected readonly ?string $logo = null,
        protected readonly ?string $banner = null,
        protected readonly ?string $thumbnail = null,
        protected readonly string $release_date,
        protected readonly array $platform = [],
        protected readonly string $description,
        protected readonly ?bool $is_featured = false,
        protected readonly ?bool $is_trending = false,
        protected readonly ?string $meta_title = null,
        protected readonly ?string $meta_description = null,
        protected readonly ?string $meta_keywords = null,
        protected readonly ?int $creater_id = null
    ) {
        if ($this->creater_id === null) {
            $this->creater_id = admin()->id;
        }
    }

    /**
     * Create DTO from array data
     */
    public static function formArray(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'] ?? Str::slug($data['name']),
            game_category_id: $data['game_category_id'],
            status: isset($data['status']) ? GameStatus::from($data['status']) : GameStatus::ACTIVE,
            developer: $data['developer'],
            publisher: $data['publisher'],
            logo: $data['logo'] ?? null,
            banner: $data['banner'] ?? null,
            thumbnail: $data['thumbnail'] ?? null,
            release_date: $data['release_date'],
            platform: $data['platform'] ?? [],
            description: $data['description'],
            is_featured: $data['is_featured'] ?? false,
            is_trending: $data['is_trending'] ?? false,
            meta_title: $data['meta_title'] ?? null,
            meta_description: $data['meta_description'] ?? null,
            meta_keywords: $data['meta_keywords'] ?? null,
            creater_id: $data['creater_id'] ?? admin()->id,
        );
    }

     public static function formRequest($request): self
    {
        return self::formArray($request->validated());
    }

    public function setGame(array $data){
        
    }
}