<?php

namespace App\Livewire\Forms;

use App\Enums\GameStatus;
use App\Models\Game;
use Livewire\Attributes\Validate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GameForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?string $name = null;
    public ?string $slug = null;
    public ?string $description = null;
    public ?UploadedFile $logo = null;
    public ?UploadedFile $banner = null;
    public ?string $status = GameStatus::ACTIVE->value;

    public ?string $meta_title = null;
    public ?string $meta_description = null;
    public ?array $meta_keywords = [];

    public bool $remove_logo = false;
    public bool $remove_banner = false;

    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'required|string|max:255|unique:games,slug,' . $this->id
            : 'required|string|max:255|unique:games,slug';
        return [
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string',
            'logo' => 'nullable|image',
            'banner' => 'nullable|image',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|array',
            'status' => 'required|string|in:' . implode(',', array_column(GameStatus::cases(), 'value')),
            'remove_logo' => 'nullable|boolean',
            'remove_banner' => 'nullable|boolean',
        ];
    }

    public function setData(Game $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->slug = $data->slug;
        $this->description = $data->description;
        $this->status = $data->status->value;


        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        $this->meta_keywords = $data->meta_keywords;
    }

    public function reset(...$properties): void
    {
        $this->name = null;
        $this->slug = null;
        $this->logo = null;
        $this->banner = null;
        $this->description = null;
        $this->status = null;
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
