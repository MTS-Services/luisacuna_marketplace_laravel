<?php



namespace App\Livewire\Backend\Admin\EmailTemplates;

use Livewire\Component;
use App\Models\EmailTemplate;

class Show extends Component
{
    public $template;

    // Mount function – যখন কম্পোনেন্ট লোড হবে তখন টেমপ্লেট আইডি অনুযায়ী ডেটা আনবে
    public function mount($id)
    {
        $this->template = EmailTemplate::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.backend.admin.email-templates.show');
    }
}
