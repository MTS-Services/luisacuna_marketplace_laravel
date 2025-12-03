<?php

namespace App\Livewire\Frontend\Game;

use Livewire\Component;

class BuyComponent extends Component
{

    public $gameSlug;
    public $categorySlug;
    public $itemSlug;

    public function mount($gameSlug, $categorySlug, $itemSlug)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->itemSlug = $itemSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.buy-component');
    }
}
