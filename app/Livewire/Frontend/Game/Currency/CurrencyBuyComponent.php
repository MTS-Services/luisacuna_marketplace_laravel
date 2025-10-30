<?php

namespace App\Livewire\Frontend\Game\Currency;

use Livewire\Component;

class CurrencyBuyComponent extends Component
{
    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.currency.currency-buy-component');
    }
}
