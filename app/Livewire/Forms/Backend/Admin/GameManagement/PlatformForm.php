<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;


use App\Enums\PlatformStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class PlatformForm extends Form
{


    #[Locked]
    public ?int $id = null;


    public string $name = '';
    public ?string $status = null;
    public ?UploadedFile $icon = null;

    public bool $remove_file = false;

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(PlatformStatus::cases(), 'value')),
            'icon' => 'nullable|image|max:2048|dimensions:max_width=200,max_height=200',
            'remove_file' => 'nullable|boolean',
        ];

        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        // $this->avatar = $data->avatar;

    }

    public function reset(...$properties): void
    {
        $this->id = null;

        $this->name = '';

        $this->status = PlatformStatus::ACTIVE->value;

        $this->remove_file = false;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
