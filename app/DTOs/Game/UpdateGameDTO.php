<?php

namespace App\DTOs\Game;

use App\Enums\GameStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UpdateGameDTO
{
    public function __construct(

        protected readonly int $game_category_id,
        protected readonly string $name,
        protected readonly string $slug,
        protected readonly GameStatus $status = GameStatus::ACTIVE,
        protected readonly string $developer,
        protected readonly string $publisher,
        protected readonly string $release_date,
        protected readonly array $platform = [],
        protected readonly string $description,

        public readonly ?UploadedFile $logo = null,
        public readonly ?UploadedFile $banner = null,
        public readonly ?UploadedFile $thumbnail = null,

        protected readonly ?bool $is_featured = false,
        protected readonly ?bool $is_trending = false,
        protected readonly ?string $meta_title = null,
        protected readonly ?string $meta_description = null,
        protected readonly ?string $meta_keywords = null,
        public readonly ?int $updater_id = null
    ) {
        if ($this->updater_id === null) {
            $this->updater_id = admin()->id;
        }
    }

    public static function formArray(array $data): self
    {
        return new self(
            game_category_id: $data['game_category_id'],
            name: $data['name'],
            slug: $data['slug'] ?? Str::slug($data['name']),
            status: isset($data['status']) ? GameStatus::from($data['status']) : GameStatus::ACTIVE,
            developer: $data['developer'],
            publisher: $data['publisher'],
            release_date: $data['release_date'],
            platform: $data['platform'] ?? [],
            description: $data['description'],

            logo: $data['logo'] ?? null,
            banner: $data['banner'] ?? null,
            thumbnail: $data['thumbnail'] ?? null,

            is_featured: $data['is_featured'] ?? false,
            is_trending: $data['is_trending'] ?? false,

            meta_title: $data['meta_title'] ?? null,
            meta_description: $data['meta_description'] ?? null,
            meta_keywords: $data['meta_keywords'] ?? null,
            updater_id: $data['updater_id'] ?? admin()->id,
        );
    }
    public static function formRequest($request): self
    {
        return self::formArray($request->validated());
    }

    public function toArray(): array
    {
        return [

            'game_category_id' => $this->game_category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status->value,
            'developer' => $this->developer,
            'publisher' => $this->publisher,
            'release_date' => $this->release_date,
            'platform' => $this->platform,
            'description' => $this->description,

            'is_featured' => $this->is_featured,
            'is_trending' => $this->is_trending,

            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'updater_id' => $this->updater_id
        ];
    }
}
