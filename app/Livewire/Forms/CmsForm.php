<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;

class CmsForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public string $content = '';

    public function rules(): array
    {
        $rules = [
            'content' => 'required|string',
        ];

        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->content = $data->content ?? '';
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->content = '';
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}