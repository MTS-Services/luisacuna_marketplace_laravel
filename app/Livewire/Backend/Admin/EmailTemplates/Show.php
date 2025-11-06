<?php

namespace App\Http\Livewire\Backend\Admin\EmailTemplates;


use Livewire\Component;
use App\Models\EmailTemplate;

class Show extends Component
{
    public $template;

    public function mount($id)
    {
        $this->template = EmailTemplate::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.show');
    }
}
