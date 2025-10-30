<?php

namespace App\Livewire\Frontend\Game\Boosting;

use Livewire\Component;

class BoostingBuyComponent extends Component
{

    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.boosting.boosting-buy-component');
    }
}
