<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GameForm extends Form
{
    // 

    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?int $category_id;

    public ?string $status;

    public ?string $slug;

    public  ?UploadedFile $logo = null;

    public ?array $platforms = [];

    public ?array $servers = [];

    public ?array $tags = [];
    

    public ?string $description;

    public ?bool $is_featured = false;

    public ?bool $is_trending = false;

    public ?string $meta_title;

    public ?string $meta_description;

    public ?string $meta_keywords;

    public ?bool $remove_file = false;

    public function rules() :array 
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => $this->isUpdating() ? 'required|string|unique:games,slug,'.$this->id : 'required|string|unique:games,slug',
            'category_id' => 'nullable|integer',
            'status' => 'required|string|in:'.implode(',', array_column(GameStatus::cases(), 'value')),
            'logo' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'platforms' => 'nullable|array',
            'servers' => 'nullable|array',
            'tags' => 'nullable|array',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'remove_file' => 'nullable|boolean',
        ];
    }

    public function setData(Game $data) :void 
    {
        $this->id = $data->id;
        $this->category_id = $data->category_id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->platforms = $data->platform;
        $this->servers = $data->servers;
        $this->tags = $data->tags;
        $this->description = $data->description;
        $this->is_featured = $data->is_featured;
        $this->is_trending = $data->is_trending;
        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        $this->meta_keywords = $data->meta_keywords;
        $this->slug = $data->slug;
        
    }

    public function reset(...$properties):void {
        $this->name = null;
        $this->category_id = null;
        $this->status = null;
        $this->logo = null;
        $this->platforms = [];
        $this->servers = [];
        $this->tags = [];
        $this->description = null;
        $this->is_featured = null;
        $this->is_trending = null;
        $this->meta_title = null;
        $this->meta_description = null;
        $this->meta_keywords = null;

        $this->resetValidation();
    }
    public function isUpdating():bool {
        return isset($this->id);
    }   
}
