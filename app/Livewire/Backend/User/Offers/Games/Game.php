<?php

namespace App\Livewire\Backend\User\Offers\Games;

use App\Services\GameService;
use Livewire\Component;

class Game extends Component
{
    public $sessionData = [];
    public $data = [];
    public Game $game;
    protected GameService $service;

  public function boot(GameService $service)
    {
        $this->service = $service;
    }
    public function mount(GameService $gameService)
    {
       $this->sessionData = session()->get('offer_history_'.user()->id);
        $this->data = $this->service->findData($this->sessionData['selectedGame'])->load('servers','rarities','platforms');
    }   
    public function render()
    {

        return view('livewire.backend.user.offers.games.game');
    }
}
