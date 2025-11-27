<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameFeature;

use App\Models\GameFeature;
use Livewire\Component;

class Show extends Component
{

    public ?GameFeature $data = null;
    public function mount(GameFeature $data){
              
        $this->data = $data;
    }

}
