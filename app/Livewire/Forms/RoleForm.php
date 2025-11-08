<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;

class RoleForm extends Form
{


    #[Locked]
    public ?int $id = null;

    public string $name = '';



    public function rules(): array
    {
        $rules = [
            'name' => $this->isUpdating() ? 'required|string|max:255|unique:roles,name,' . $this->id : 'required|string|max:255|unique:roles,name',

        ];
        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
