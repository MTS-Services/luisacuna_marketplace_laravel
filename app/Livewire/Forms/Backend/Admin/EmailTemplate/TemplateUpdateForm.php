<?php

namespace App\Livewire\Forms\Backend\Admin\TamplateUpdateForm;

use App\Models\EmailTemplate;
use Livewire\Attributes\Locked;
use Livewire\Form;

class TamplateUpdateForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public string $content = '';

    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }

    public function setData(EmailTemplate $data)
    {
        $this->id = $data->id;
        $this->content = $data->content;
    }

    public function reset(...$properties): void
    {
        if (empty($properties)) {
            $this->id = null;
            $this->content = '';
        } else {
            parent::reset(...$properties);
        }
    }

    public function isUpdating(): bool
    {
        return isset($this->id) && $this->id !== null;
    }
}