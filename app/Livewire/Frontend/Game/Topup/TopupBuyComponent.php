<?php

namespace App\Livewire\Frontend\Game\Topup;

use Livewire\Component;

class TopupBuyComponent extends Component
{

    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.topup.topup-buy-component');
    }
}
