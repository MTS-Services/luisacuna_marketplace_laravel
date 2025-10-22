<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Game;

use App\Actions\Game\CreateGameAction;
use App\DTOs\Game\CreateGameDTO;
use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;
use App\Models\GameCategory;
use App\Services\Game\GameCategoryService;
use App\Services\Game\GameService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    protected GameService $gameService;

    public GameForm $form;

    protected CreateGameAction $createAdminAction;

    protected GameCategoryService $gameCategoryService;


    public function boot(GameService $gameService, CreateGameAction $createAdminAction, GameCategoryService $gameCategoryService)  
    {
        $this->gameService = $gameService;

        $this->createAdminAction = $createAdminAction;

        $this->gameCategoryService = $gameCategoryService;


    }
    public function render()
    {
        return view('livewire.backend.admin.components.game-management.game.create', [

            'statuses'   => GameStatus::options(),

            'categories' => $this->gameCategory(),

        ]);
    }

    protected function gameCategory():array
    {
        return $this->gameCategoryService->all()->pluck('name', 'id')->toArray();
    }
    public function save(){
     
        $data = $this->form->validate();

        $dto = CreateGameDTO::formArray([
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
        try {

            $this->gameService->createGame($dto);

            return $this->redirect(route('admin.gm.game.index'), navigate: true);

        } catch (\Throwable $th) {
            dd('Exectured'.$th->getMessage());
        }

    }
}
