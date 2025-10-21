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

        $dto = CreateGameDTO::formArray($data);
        try {

            $this->createAdminAction->execute($dto);

            return $this->redirect(route('admin.gm.game.index'), navigate: true);

        } catch (\Throwable $th) {
            dd('Exectured'.$th->getMessage());
        }

    }
}
