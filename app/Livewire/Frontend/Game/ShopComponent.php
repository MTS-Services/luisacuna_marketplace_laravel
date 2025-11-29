<?php

namespace App\Livewire\Frontend\Game;

use Livewire\Component;

class ShopComponent extends Component
{
    public $gameSlug;
    public $categorySlug;
    public $datas = [];

    public function mount($gameSlug, $categorySlug)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->datas = [1,2,3,4,5,6,7]; // Initialize datas as an empty array
    }
    public function render()
    {
        return view('livewire.frontend.game.shop-component', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'datas' => $this->datas,
        ]);
    }
}
