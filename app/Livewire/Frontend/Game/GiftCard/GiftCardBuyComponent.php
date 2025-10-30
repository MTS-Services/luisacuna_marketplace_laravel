<?php

namespace App\Livewire\Frontend\Game\GiftCard;

use Livewire\Component;

class GiftCardBuyComponent extends Component
{

    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.gift-card.gift-card-buy-component');
    }
}
