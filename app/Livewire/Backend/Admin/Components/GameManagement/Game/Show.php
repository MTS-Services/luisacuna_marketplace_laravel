<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Game;

use App\Models\Game;
use Livewire\Component;

class Show extends Component
{


    public Game $game;
    public function mount(Game $game){

        $this->game = $game;

    }
    public function render()
    {
        return view('livewire.backend.admin.components.game-management.game.show');
    }
}
