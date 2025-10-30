<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;
use Illuminate\Support\Str;

class PageInnerHeader extends Component
{


    public $gameSlug;
    public $gameName;

    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
        $this->gameName = Str::ucfirst(str_replace('-', ' ', $gameSlug));
    }
    public function render()
    {
        return view('livewire.frontend.partials.page-inner-header');
    }
}
