<?php 

namespace App\Livewire\Backend\Admin\EmailTemplate;

use App\Services\EmailTemplateService;
use Livewire\Component;


class Show extends Component
{

    public string $id;

    protected EmailTemplateService $emailTemplateService;
    
    public function boot(EmailTemplateService $emailTemplateService)
    {
        $this->emailTemplateService = $emailTemplateService;
    }
    
    public function mount($id){

        $this->id = decrypt($id);

    }

    public function render()
    {

        $emailTemplate = $this->emailTemplateService->find($this->id);

        return view('livewire.backend.admin.email-template.show', compact('emailTemplate'));
    }
}