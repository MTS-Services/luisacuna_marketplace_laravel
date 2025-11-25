<?php

namespace App\Livewire\Forms;
use App\Enums\TagStatus;
use App\Models\Tag;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;
class TagForm extends Form
{
    //

    #[Locked]

    public ?int $id = null;

    public ?string $name = null;
    public ?string $slug = null;

    public ?int $sort_order = null;


    public ?string $text_color = null;

    public ?string $bg_color = null;

    public ?string $status = TagStatus::ACTIVE->value;

    public ?UploadedFile $icon = null;


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(Tag::class, 'slug')->ignore($this->id),
            ],
            'text_color' => 'nullable|string|max:7',
            'bg_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|string|in:' . implode(',', array_column(TagStatus::cases(), 'value')),
            'icon' => 'nullable|image|max:1024|dimensions:max_width=200,max_height=201',
        ];
    }

    public function setData(Tag $data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->slug = $data->slug;
        $this->text_color = $data->text_color;
        $this->bg_color = $data->bg_color;
        $this->sort_order = $data->sort_order;
        $this->icon = null;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = null;
        $this->slug = null;
        $this->text_color = null;
        $this->bg_color = null;
        $this->sort_order = null;
        $this->status = TagStatus::ACTIVE->value;
        $this->icon = null;
        $this->resetValidation();
    }


    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
