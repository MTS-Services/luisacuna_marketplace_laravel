<?php

namespace App\Livewire\Forms\Backend\Admin\EmailManagement;

use App\Models\EmailTemplate;
use Livewire\Attributes\Locked;
use Livewire\Form;

class TemplateUpdateForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?string $template;

    public ?string $name = null; 

    public ?string $subject = null;

    public function rules(): array
    {

     $idRule = !$this->isUpdating()
            ? 'nullable'
            : 'required|integer';
        return [
            'template' => 'required|string',
            'id' => $idRule,
            'subject' => 'required|string',
        ];
    }

    public function setData(EmailTemplate $data)
    {
        $this->id = $data->id;
        $this->template = $data->template;
        $this->name = $data->name;
        $this->subject = $data->subject;
    }

    public function reset(...$properties): void
    {
        if (empty($properties)) {
            $this->id = null;
            $this->template = '';
            $this->name = '';
            $this->subject = '';
            
        } else {
            parent::reset(...$properties);
        }
    }

    public function isUpdating(): bool
    {
        return isset($this->id) && $this->id !== null;
    }
}