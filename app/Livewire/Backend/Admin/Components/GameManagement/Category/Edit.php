<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Category;

use App\DTOs\GameCategory\UpdateGameCategoryDTO;
use App\Enums\GameCategoryStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameCategory;
use App\Models\GameCategory as ModelsGameCategory;
use App\Services\Game\GameCategoryService;
use Livewire\Component;

class Edit extends Component
{
    public GameCategory $form; 
    public ModelsGameCategory $ModelsGameCategory;
    protected GameCategoryService $gameCategoryService;
    public $categoryId = null;

    public function boot(GamecategoryService $gameCategoryService){
        $this->gameCategoryService = $gameCategoryService;
    }
    public function mount(ModelsGameCategory $category){
       $this->form->setCategory($category);
       $this->categoryId = $category->id ;
     
    }
    public function render()
    {
        return view('livewire.backend.admin.components.game-management.category.edit', [
            'statuses'   => GameCategoryStatus::options(),
        ]);
    }


    public function update(){
       $data =  $this->form->validate();

       try {
       $dto = UpdateGameCategoryDTO::formArray($data);
     
          $this->gameCategoryService->update($this->categoryId, $dto->toArray());

       return $this->redirect(route('admin.gm.category.index'), navigate: true);

       } catch (\Throwable $th) {
      
        dd($th->getMessage());
       }
    }
}
