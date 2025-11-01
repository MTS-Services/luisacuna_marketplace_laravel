<?php

namespace App\Livewire\Frontend\Game\Item;

use Livewire\Component;

class ItemBuyComponent extends Component
{

    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.item.item-buy-component');
    }
}
