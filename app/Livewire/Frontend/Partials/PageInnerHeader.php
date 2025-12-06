<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class PageInnerHeader extends Component
{


    public $gameSlug;
    public $categorySlug;
    public $game;

    public function mount($gameSlug, $categorySlug, $game)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->game = $game;
    }
    public function render()
    {
        return view('livewire.frontend.partials.page-inner-header');
    }
}
