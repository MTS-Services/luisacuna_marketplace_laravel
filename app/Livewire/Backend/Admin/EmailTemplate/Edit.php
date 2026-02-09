<?php

namespace App\Livewire\Backend\Admin\EmailTemplate;


use Livewire\Component;
use App\Services\EmailTemplateService;
use App\Livewire\Forms\Backend\Admin\EmailManagement\TemplateUpdateForm;
use App\Traits\Livewire\WithNotification;

class Edit extends Component
{

    use WithNotification;

    public TemplateUpdateForm $form;

    public $variables = [];

    protected EmailTemplateService $emailTemplate;

    public function boot(EmailTemplateService $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function mount($id)
    {
        $templateId = decrypt($id);

        $template = $this->emailTemplate->find($templateId);

        $this->variables = $template->variables;
        // Initialize form manually
        // $this->form = new TemplateUpdateForm($this, 'form');

        $this->form->setData($template);

    }

    public function save(){
        $data = $this->form->validate();
        try {
           $this->emailTemplate->update($data['id'], $data);
            $this->success('Template updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update template');
        }
    }

    public function resetForm(){
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.backend.admin.email-template.edit');
    }
}
