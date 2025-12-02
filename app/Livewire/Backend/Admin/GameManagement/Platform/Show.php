<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Models\Platform;
use Livewire\Component;

class Show extends Component
{

    public ?Platform $data = null;
    public function mount(Platform $data){

        $this->data = $data;
    }

}
