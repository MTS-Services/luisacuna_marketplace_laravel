<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GameCategoryForm extends Form
{

    #[Locked]
    public ?int $id;

    public string $name;
    public ?string $description;
    public string $status;




    public function rules(): array
    {
        return [
            'name' => $this->isUpdating() ? 'required|string|max:255|unique:game_categories,name,'.$this->id : 'required|string|max:255|unique:game_categories,name' ,
            'description' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(GameCategoryStatus::cases(), 'value')),
        ];

    }

    public function setCategory(GameCategory $data){
        $this->id = $data->id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->status = $data->status->value;
    }

    public function reset(...$properties): void{
        $this->id = null;
        $this->name = '';
        $this->description = '';
        $this->status = GameCategoryStatus::ACTIVE->value;
        $this->resetValidation();
    }

    public function fillables(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }

    public function isUpdating(): bool
    {
        return isset($this->id);
    }

}
