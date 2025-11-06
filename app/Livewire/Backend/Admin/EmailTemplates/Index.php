<?php

namespace App\Livewire\Backend\Admin\EmailTemplates;


use Livewire\Component;
use App\Models\EmailTemplate;

class Index extends Component
{
    public function delete($id)
    {
        EmailTemplate::findOrFail($id)->delete();
        session()->flash('success', 'Template moved to trash!');
    }

    public function render()
    {
        $templates = EmailTemplate::latest()->get();
        return view('livewire.backend.admin.email-templates.index', compact('templates'));
    }
}
