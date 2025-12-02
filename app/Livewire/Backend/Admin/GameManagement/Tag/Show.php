<?php

namespace App\Livewire\Backend\Admin\GameManagement\Tag;

use App\Models\Tag;
use Livewire\Component;

class Show extends Component
{

    public ?Tag $data = null;
    public function mount(Tag $data){

        $this->data = $data;
    }

}
