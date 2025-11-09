<?php


namespace App\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;
use App\Services\EmailTemplateService;

class Index extends Component
{
    public $templates;
    protected $service;

    //   public function boot(EmailTemplateService $service)
    // {
    //     $this->service = $service;
    // }

    public function mount()
    {
        // $this->service = $service;
        // $this->templates = $this->service->getAll();
        $this->templates = EmailTemplate::latest()->get();
    }

    public function delete($id)
    {

        // $this->service->softDelete($id);
        // session()->flash('success', 'Template moved to trash!');
        // $this->templates = $this->service->getAll();

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



// namespace App\Livewire\Backend\Admin\EmailTemplates;

// use Livewire\Component;
// use App\Services\EmailTemplateService;

// class Index extends Component
// {
//     public $templates;

//     protected $service;

//     /**
//      * Constructor Dependency Injection
//      */
//     public function boot(EmailTemplateService $service)
//     {
//         $this->service = $service;
//     }

//     /**
//      * Mount – Load all templates initially
//      */
//     public function mount()
//     {
//         $this->loadTemplates();
//     }

//     /**
//      * Load templates via Service
//      */
//     private function loadTemplates()
//     {
//         $this->templates = $this->service->getAll();
//     }

//     /**
//      * Soft Delete Template (move to trash)
//      */
//     public function delete($id)
//     {
//         try {
//             $this->service->softDelete($id);
//             session()->flash('success', 'Template moved to trash successfully!');
//         } catch (\Exception $e) {
//             session()->flash('error', 'Failed to delete template: ' . $e->getMessage());
//         }

//         $this->loadTemplates();
//     }

//     /**
//      * Render the view
//      */
//     public function render()
//     {
//         return view('livewire.backend.admin.email-templates.index');
//     }
// }
