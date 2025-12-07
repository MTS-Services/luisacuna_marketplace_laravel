<?php

namespace App\Livewire\Backend\Admin\FaqManagement\Faq;

use App\Models\Faq;
use Livewire\Component;

class Show extends Component
{
    public Faq $data;
    public function mount(Faq $data)
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.faq-management.faq.show');
    }
}
