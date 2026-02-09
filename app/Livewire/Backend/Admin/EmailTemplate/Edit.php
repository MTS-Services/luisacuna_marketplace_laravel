<?php

namespace App\Livewire\Backend\Admin\EmailTemplate;

use App\Livewire\Forms\Backend\Admin\TamplateUpdateForm\TamplateUpdateForm;
use Livewire\Component;
use App\Services\EmailTemplateService;

class Edit extends Component
{

    public $id;
    public $content; 
    public $variables = [];

    public TamplateUpdateForm $form;

    protected EmailTemplateService $emailTemplate;

    public function boot(EmailTemplateService $emailTemplate){

        $this->emailTemplate = $emailTemplate;

    }

    public function mount($id){

        $this->id = decrypt($id);

    }
    public function render()
    {
       $template = $this->emailTemplate->find($this->id);

       $this->variables = $template->variables;

       $this->form->setData($template);

        return view('livewire.backend.admin.email-template.edit',[
            'template' => $template,
        ]);
    }

    public function save(){

        dd($this->content);
    }
}
