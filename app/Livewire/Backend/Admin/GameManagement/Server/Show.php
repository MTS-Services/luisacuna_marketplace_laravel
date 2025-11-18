<?php

namespace App\Livewire\Backend\Admin\GameManagement\Server;

use App\Models\Server;
use Livewire\Component;

class Show extends Component
{

    public ?Server $data = null;
    public function mount(Server $data){
              
        $this->data = $data;
    }

}
