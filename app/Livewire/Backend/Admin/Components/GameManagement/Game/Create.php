<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Game;

use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\Game;
use App\Services\Game\GameService;
use Livewire\Component;

class Create extends Component
{
    protected GameService $gameService;
    public Game $form;
    public function boot(GameService $gameService)  
    {
        $this->gameService = $gameService;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.game-management.game.create', [
            'statuses'   => GameStatus::options(),
        ]);
    }


    public function save(){
     
        $this->form->validate();


        dd('Working');

    }
}
