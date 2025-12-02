<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\GameService;

class Home extends Component
{
    public $input;
    public $email;
    public $password;
    public $disabled;

    public $standardSelect;
    public $disabledSelect;
    public $select2Single;
    public $select2Multiple;

    public $content = '<p>This is the initial content of the editor.</p>';

    protected GameService $gameService;
    public function boot(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function saveContent()
    {
        dd($this->content);
    }
    public function saveContent2()
    {
        dd($this->content);
    }

    public function render()
    {
        $games = $this->gameService->getAllDatas();
        $hero = [];
        return view('livewire.frontend.home', [
            'games' => $games,
            'hero' => $hero,
        ]);
    }
}
