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
    protected GameCategoryService $categoryService;

    protected GameService $service;

    protected $dataId = null;

    public function boot(GameCategoryService $categoryService, GameService $service){

        $this->categoryService = $categoryService;

        $this->service = $service;


    }
    public function mount(Game $data){
       $this->form->setData($data);
       $this->dataId = $data->id;
    }

    public function render()
    {
       $platforms = [
        [
            'id' => 1,
            'name' => 'PC'
        ], 
        [
            'id' => 2,
            'name' => 'Mobile'
        ],
        [
            'id' => 3,
            'name' => 'Web'
        ],
        [
            'id' => 4,
            'name' => 'Console'
        ]
       ];
        return view('livewire.backend.admin.components.game-management.game.edit', [

            'statuses'   => GameStatus::options(),
            'categories' => $this->categories(),
            'platforms'  => $platforms,
        ]);
    }

    protected function categories(){
        return $this->categoryService->getAllDatas()->pluck('name', 'id')->toArray();
    }


    public function update(){

        $this->form->validate();

        try {
            $data = $this->form->fillables();

            $actioner_id = admin()->id; 

            $this->service->updateData($this->dataId, $data, $actioner_id);

        } catch (\Exception $e) {
            $this->error('Failed to update game: ' . $e->getMessage());
            return;
        }

        $this->service->updateGame($this->game->id, $dto);

        return $this->redirect(route('admin.gm.game.index'), navigate: true);
    }

    public function cancel(){

        return $this->redirect(route('admin.gm.game.index'), navigate: true);

    }

}
