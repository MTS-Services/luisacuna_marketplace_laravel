<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Category;

use App\DTOs\GameCategory\CreateGameCategoryDTO;
use App\Enums\GameCategoryStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameCategory;
use App\Services\Game\GameCategoryService;
use Livewire\Component;

class Create extends Component
{
    protected GameCategoryService $gameCategoryService;
    public GameCategory $form;

    public function boot(GameCategoryService $gameCategoryService){
       $this->gameCategoryService = $gameCategoryService;
    }

    // public function mount(){
    //    $this->form->status = GameCategoryStatus::ACTIVE->value;
    // }
    public function render()
    {
        // dd($this->form);

        return view('livewire.backend.admin.components.game-management.category.create', [
            'statuses'   => GameCategoryStatus::options(),
        ]);
    }


    public function save()
    {
        $data = $this->form->validate();
       
        try {
            $data = CreateGameCategoryDTO::formArray($data);
            
           $data =  $this->gameCategoryService->create($data);
            
            return $this->redirect(route('admin.gm.category.index'), navigate: true);
           
        } catch (\Throwable $th) {

            dd($th->getMessage());
            
        }
    }
}
