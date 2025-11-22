<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;

class RoleForm extends Form
{


    #[Locked]
    public ?int $id = null;
    public string $name = '';

    public ?array $permissions = [];

    public function rules(): array
    {
        $rules = [
            'name' => $this->isUpdating() ? 'required|string|max:255|unique:roles,name,' . $this->id : 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->permissions = $data->permissions()->pluck('id')->toArray();
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->permissions = [];
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
