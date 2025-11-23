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
    public ?string $slug;
    public array $categories = [];
    public ?array $servers = [];
    public ?array $platforms = [];
    public ?array $rarities = [];
    public ?array $types = [];
    public ?array $tags = [];
    public ?string $status;
    public ?UploadedFile $logo = null;

    public ?string $description;

    public ?string $meta_title;

    public ?string $meta_description;

    public ?string $meta_keywords;

    public ?bool $remove_file = false;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => $this->isUpdating() ? 'required|string|unique:games,slug,' . $this->id : 'required|string|unique:games,slug',
            'categories' => 'required|array',
            'types' => 'nullable|array',
            'rarities' => 'nullable|array',
            'platforms' => 'nullable|array',
            'tags' => 'nullable|array',
            'servers' => 'nullable|array',
            'logo' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',

            'status' => 'required|string|in:' . implode(',', array_column(GameStatus::cases(), 'value')),
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'remove_file' => 'nullable|boolean',
        ];
    }

    public function setData(Game $data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->slug = $data->slug;
        $this->logo = $data->logo;
        $this->categories = $data->categories;
        $this->types = $data->types;
        $this->rarities = $data->rarities;
        $this->platforms = $data->platforms;
        $this->servers = $data->servers;
        $this->tags = $data->tags;
        $this->status = $data->status->value;
        $this->description = $data->description;

        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        $this->meta_keywords = $data->meta_keywords;

    }

    public function reset(...$properties): void
    {
        $this->name = null;
        $this->slug = null;
        $this->logo = null;
        $this->categories = [];
        $this->tags = [];
        $this->servers = [];
        $this->platforms = [];
        $this->rarities = [];
        $this->types = [];
        $this->status = null;
        $this->description = null;
        $this->meta_title = null;
        $this->meta_description = null;
        $this->meta_keywords = null;

        $this->resetValidation();
    }
    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
