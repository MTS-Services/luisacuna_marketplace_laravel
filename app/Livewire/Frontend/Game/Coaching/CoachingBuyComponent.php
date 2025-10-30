<?php

namespace App\Livewire\Frontend\Game\Coaching;

use Livewire\Component;

class CoachingBuyComponent extends Component
{
    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.coaching.coaching-buy-component');
    }
}
