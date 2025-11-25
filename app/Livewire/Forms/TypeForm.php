<?php

namespace App\Livewire\Forms;
use App\Enums\TypeStatus;
use App\Models\Type;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class TypeForm extends Form
{


    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?string $status;

    public ?UploadedFile $icon = null;

    public ?int $sort_order = null;


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(TypeStatus::cases(), 'value')),
            'icon' => 'nullable|image|max:1024|dimensions:max_width=200,max_height=201',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function setData(Type $data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->sort_order = $data->sort_order;
        $this->icon = null;


    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = null;
        $this->status = TypeStatus::ACTIVE->value;
        $this->icon = null;
        $this->sort_order = 0;
        $this->resetValidation();
    }


    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
