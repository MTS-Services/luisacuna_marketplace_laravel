<?php

namespace App\Livewire\Frontend\Game\Account;

use Livewire\Component;

class AccountBuyComponent extends Component
{

    public $gameSlug;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.account.account-buy-component');
    }
}
