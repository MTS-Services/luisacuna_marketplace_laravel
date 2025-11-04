<?php

namespace App\Http\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;

class Show extends Component
{
    public $template;

    // mount() method দিয়ে route থেকে ডাটা আনবো
    public function mount($id)
    {
        $this->template = EmailTemplate::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.show', [
            'template' => $this->template,
        ]);
    }
}
