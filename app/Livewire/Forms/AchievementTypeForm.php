<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

class AchievementTypeForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?string $name = null;
    public bool $is_active = false;


    /**
     * Validation rules (handles create/update logic)
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Fill the form fields from a Language model
     */

    public function setData($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->is_active = (bool) $data->is_active;
    }
    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = null;
        $this->is_active = false;
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
