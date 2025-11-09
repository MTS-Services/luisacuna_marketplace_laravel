<?php


namespace App\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;

class Edit extends Component
{
    public $template;
    public $sort_order, $key, $name, $subject, $body, $variables;

    public function mount($id)
    {
        $this->template = EmailTemplate::findOrFail($id);

        $this->sort_order = $this->template->sort_order;
        $this->key        = $this->template->key;
        $this->name       = $this->template->name;
        $this->subject    = $this->template->subject;
        $this->body       = $this->template->body;
        $this->variables  = is_array($this->template->variables)
            ? implode(',', $this->template->variables)
            : $this->template->variables;
    }

    protected $rules = [
        'sort_order' => 'nullable|integer',
        'key'        => 'required|string|max:255',
        'name'       => 'required|string|max:255',
        'subject'    => 'required|string|max:255',
        'body'       => 'required|string',
        'variables'  => 'nullable|string',
    ];

    public function update()
    {
        $data = $this->validate();

        if (!empty($this->variables)) {
            $data['variables'] = explode(',', str_replace(' ', '', $this->variables));
        }

        $this->template->update($data);

        session()->flash('success', 'Email Template updated successfully!');
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.edit');
    }
}
