<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\Models\Language;
use Livewire\Component;

class View extends Component
{
    public Language $data;
    public function mount(Language $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.settings.language.view');
    }
}
