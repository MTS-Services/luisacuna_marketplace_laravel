<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GameStatus;
use App\Models\Game as ModelsGame;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GameForm extends Form
{
    // 

    #[Validate( 'required','string',)]
    public ?string $name = null; 

    #[Validate( 'required','integer')]
    public ?string $game_category_id = null;

    #[Validate('required', 'in:active,inactive',GameStatus::class)]
    public ?string $status = null;

    #[Validate('required', 'string')]
    public ?string $developer = null;

    #[Validate('required', 'string')]
    public ?string $publisher = null;

    #[Validate('nullable', 'file', 'image', 'max:10240','mimes:jpg,jpeg,png',)]
    public ?string $logo = null;
    
    #[Validate('nullable', 'file', 'image', 'max:10240','mimes:jpg,jpeg,png',)]
    public ?string $banner = null;  

    #[Validate('required', 'date', 'after_or_equal:today')]
    public ?string $release_date = null;

    
    #[Validate('required', 'array')]
    public ?array $platform = [];

    
    #[Validate('required', 'string')]
    public ?string $description = null;

    
    #[Validate('nullable', 'file', 'image', 'max:10240','mimes:jpg,jpeg,png')]
    public ?string $thumbnail = null;
    
    #[Validate('required', 'boolean')]
    public ?bool $is_featured = false; 

    #[Validate('required', 'boolean')]
    public ?bool $is_trending = false;

    #[Validate('nullable', 'string')]
    public ?string $meta_title = null;

    #[Validate('nullable', 'string')]
    public ?string $meta_description = null;

    #[Validate('nullable', 'string')]
    public ?string $meta_keywords = null;

    public function rules() :array 
    {
        return [
            'name' => 'required|string|max:255',
            'game_category_id' => 'nullable|integer',
            'status' => 'required|string|in:'.implode(',', array_column(GameStatus::cases(), 'value')),
            'developer' => 'required|string',
            'publisher' => 'required|string',
            'logo' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'banner' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'release_date' => 'required|date|after_or_equal:today',
            'platform' => 'required|array',
            'description' => 'required|string',
            'thumbnail' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ];
    }

    public function setGame(ModelsGame $game) :void 
    {
        $this->game_category_id = $game->game_category_id;
        $this->name = $game->name;
        $this->status = $game->status;
        $this->developer = $game->developer;
        $this->publisher = $game->publisher;
        $this->logo = $game->logo;
        $this->banner = $game->banner;
        $this->release_date = $game->release_date;
        $this->platform = $game->platform;
        $this->description = $game->description;
        $this->thumbnail = $game->thumbnail;
        $this->is_featured = $game->is_featured;
        $this->is_trending = $game->is_trending;
        $this->meta_title = $game->meta_title;
        $this->meta_description = $game->meta_description;
        $this->meta_keywords = $game->meta_keywords;
        
    }
}
