<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Game;

use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\Game as GameManagementGame;
use App\Models\Game;
use Livewire\Component;

class Edit extends Component
{
    public Game $game;
    public GameManagementGame $form;
    public function mount(Game $game){
        $this->game = $game;
    }
    public function render()
    {
        $this->form->setGame($this->game);
        return view('livewire.backend.admin.components.game-management.game.edit', [

            'statuses'   => GameStatus::options(),

        ]);
    }

    public function update(){

        $this->form->validate();
    }
}
