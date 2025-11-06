<?php

namespace App\Livewire\Backend\Admin\EmailTemplates;


use Livewire\Component;
use App\Models\EmailTemplate;

class Edit extends Component
{
    public $id, $sort_order, $key, $name, $subject, $variables;

    public function mount($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $this->id = $template->id;
        $this->sort_order = $template->sort_order;
        $this->key = $template->key;
        $this->name = $template->name;
        $this->subject = $template->subject;
        $this->variables = $template->variables;
    }

    public function update()
    {
        $validated = $this->validate([
            'key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        // EmailTemplate::findOrFail($this->id)->update($validated + [
        //     'updated_by' => auth()->id(),
        // ]);

        session()->flash('success', 'Email Template Updated Successfully!');
        return redirect()->route('email_templates.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.edit');
    }
}
