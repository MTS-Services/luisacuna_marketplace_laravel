<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Game;

use App\DTOs\Game\UpdateGameDTO;
use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;
use App\Models\Game;
use App\Services\Game\GameCategoryService;
use App\Services\Game\GameService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public Game $game;
    public GameForm $form;
    protected GameCategoryService $gameCategoryService;

    protected GameService $gameService;

    public function boot(GameCategoryService $gameCategoryService, GameService $gameService){

        $this->gameCategoryService = $gameCategoryService;

        $this->gameService = $gameService;


    }
    public function mount(Game $game){
        $this->game = $game;
    }

    public function render()
    {
        $this->form->setGame($this->game);

        return view('livewire.backend.admin.components.game-management.game.edit', [

            'statuses'   => GameStatus::options(),
            'categories' => $this->categories(),
        ]);
    }

    protected function categories(){
        return $this->gameCategoryService->all()->pluck('name', 'id')->toArray();
    }


    public function update(){

        $this->form->validate();

        $dto = UpdateGameDTO::formArray([
            'game_category_id' => $this->form->game_category_id,
            'name' => $this->form->name,
            'status' => $this->form->status,
            'developer' => $this->form->developer,
            'publisher' => $this->form->publisher,
            'release_date' => $this->form->release_date,
            'platform' => $this->form->platform,
            'description' => $this->form->description,

            'is_featured' => $this->form->is_featured,
            'is_trending' => $this->form->is_trending,

            'logo' => $this->form->logo,
            'banner' => $this->form->banner,
            'thumbnail' => $this->form->thumbnail,
            
            'meta_title' => $this->form->meta_title,
            'meta_description' => $this->form->meta_description,
            'meta_keywords' => $this->form->meta_keywords,
        ]);

        $this->gameService->updateGame($this->game->id, $dto);

        return $this->redirect(route('admin.gm.game.index'), navigate: true);
    }

}
