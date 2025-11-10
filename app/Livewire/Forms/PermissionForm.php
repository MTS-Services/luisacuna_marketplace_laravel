<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;

class PermissionForm extends Form
{


    #[Locked]
    public ?int $id = null;

    public string $prefix = '';
    public string $name = '';



    public function rules(): array
    {
        $rules = [
            'name' => $this->isUpdating() ? 'required|string|max:255|unique:permissions,name,' . $this->id : 'required|string|max:255|unique:permissions,name',
            'prefix' => $this->isUpdating() ? 'required|string|max:255|unique:permissions,prefix,' . $this->id : 'required|string|max:255|unique:permissions,prefix',

        ];
        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->prefix = $data->prefix;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->prefix = '';
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
