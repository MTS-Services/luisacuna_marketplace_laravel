<?php


namespace App\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;

class Create extends Component
{
    public $sort_order, $key, $name, $subject, $body, $variables;

    protected $rules = [
        'sort_order' => 'nullable|integer',
        'key'        => 'required|unique:email_templates,key',
        'name'       => 'required|string|max:255',
        'subject'    => 'required|string|max:255',
        'body'       => 'required|string',
        'variables'  => 'nullable|string',
    ];

    public function save()
    {
        $data = $this->validate();

        // variables JSON format এ রূপান্তর
        if (!empty($this->variables)) {
            $data['variables'] = explode(',', str_replace(' ', '', $this->variables));
        }

        EmailTemplate::create($data);

        session()->flash('success', 'Email Template created successfully!');
        $this->reset(); // ফর্ম ক্লিয়ার করে দিবে
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.create');
    }
}
