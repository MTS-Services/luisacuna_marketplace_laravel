<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;


use App\Enums\TagStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class TagForm extends Form
{


    #[Locked]
    public ?int $id = null;


    public string $name = '';
    public ?string $status = null;
    public ?UploadedFile $icon = null;

    public ?string $text_color = null;

    public ?string $bg_color = null;

    public bool $remove_file = false;

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(TagStatus::cases(), 'value')),
            'icon' => 'nullable|image|max:2048|dimensions:max_width=200,max_height=200',
            'remove_file' => 'nullable|boolean',
            'text_color' => 'nullable|string',
            'bg_color' => 'nullable|string',
        ];

        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->text_color = $data->text_color;
        $this->bg_color = $data->bg_color;
        // $this->avatar = $data->avatar;

    }

    public function reset(...$properties): void
    {
        $this->id = null;

        $this->name = '';

        $this->status = TagStatus::ACTIVE->value;

        $this->remove_file = false;
        $this->text_color = null;
        $this->bg_color = null;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
