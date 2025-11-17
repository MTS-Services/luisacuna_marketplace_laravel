<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameServer;

use App\Models\GameServer;
use Livewire\Component;

class Show extends Component
{

    public ?GameServer $data = null;
    public function mount(GameServer $data){
       
       
        $this->data = $data;
    }

}
