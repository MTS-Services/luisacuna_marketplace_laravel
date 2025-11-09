<?php


namespace App\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;

class Index extends Component
{
    public $templates;

    public function mount()
    {
        $this->templates = EmailTemplate::latest()->get();
    }

    public function delete($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete(); // Soft delete
        $this->templates = EmailTemplate::latest()->get();
        session()->flash('message', 'Template moved to trash successfully!');
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.index');
    }
}
