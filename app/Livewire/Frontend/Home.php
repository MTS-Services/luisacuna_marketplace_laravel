<?php

namespace App\Livewire\Frontend;

use App\Models\Tag;
use Livewire\Component;
use App\Services\GameService;
use App\Services\HeroService;
use App\Services\TagService;

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
    protected HeroService $heroService;
    protected TagService $tagService;
    public function boot(GameService $gameService, HeroService $heroService, TagService $tagService)
    {
        $this->tagService = $tagService;
        $this->gameService = $gameService;
        $this->heroService = $heroService;
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
        $hero = $this->heroService->getFirstActiveData();

        $tag = $this->tagService->findData('popular', 'slug');
      
        $games = $tag->games()->latest()->take(6)->get();
        $games->load('categories');
     
      
        return view('livewire.frontend.home', [
            'games' => $games,
            'hero' => $hero,
        ]);
    }
}
