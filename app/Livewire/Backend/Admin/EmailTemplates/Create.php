<?php

namespace App\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;
class Create extends Component
{

    public $sort_order, $key, $name, $subject, $variables;

    protected $rules = [
        'sort_order' => 'nullable|integer',
        'key' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'subject' => 'nullable|string|max:255',
        'variables' => 'nullable|string',
    ];
    public function save()
    {
        $validated = $this->validate();
        // $validated['created_by'] = auth()->id();
        EmailTemplate::create($validated);
        session()->flash('success', 'Email Template Created Successfully!');
        return redirect()->route('email_templates.index');
    }

    
    public function render()
    {
        return view('livewire.backend.admin.email-templates.create');
    }
}
