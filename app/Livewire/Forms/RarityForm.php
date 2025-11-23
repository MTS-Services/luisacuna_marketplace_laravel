<?php

namespace App\Livewire\Forms;

;
use App\Enums\RarityStatus;
use App\Models\Rarity;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class RarityForm extends Form
{
    //

    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?string $status;

    public ?UploadedFile $icon = null;

    public ?bool $remove_file = false;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(RarityStatus::cases(), 'value')),
            'icon' => 'nullable|image|max:1024|dimensions:max_width=200,max_height=201',
            'remove_file' => 'nullable|boolean',
        ];
    }

    public function setData(Rarity $data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;

    }

    public function reset(...$properties): void
    {
        $this->name = null;
        $this->status = RarityStatus::ACTIVE->value;
        $this->id = null;
        $this->icon = null;
        $this->remove_file = false;
        $this->resetValidation();
    }


    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
