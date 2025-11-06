<?php

namespace App\Http\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;

class Trash extends Component
{
    public function restore($id)
    {
        EmailTemplate::onlyTrashed()->findOrFail($id)->restore();
        session()->flash('success', 'Template restored successfully!');
    }

    public function deletePermanently($id)
    {
        EmailTemplate::onlyTrashed()->findOrFail($id)->forceDelete();
        session()->flash('success', 'Template deleted permanently!');
    }

    public function render()
    {
        $trashed = EmailTemplate::onlyTrashed()->get();
        return view('livewire.backend.admin.email-templates.trash', compact('trashed'));
    }
}
