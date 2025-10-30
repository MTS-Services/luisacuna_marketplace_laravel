<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class PageInnerHeader extends Component
{


    public $gameName;

    public function mount($gameName)
    {
        $this->gameName = $gameName;
    }
    public function render()
    {
        return view('livewire.frontend.partials.page-inner-header');
    }
}
