<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Category;

use App\DTOs\Game\CreateGameCategoryDTO ;
use App\Enums\GameCategoryStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameCategoryForm;
use App\Services\Game\GameCategoryService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    use WithNotification;
    protected GameCategoryService $service;
    public GameCategoryForm $form;

    public function boot(GameCategoryService $service)
    {
        $this->service = $service;
    }

    // public function mount(){
    //    $this->form->status = GameCategoryStatus::ACTIVE->value;
    // }
    public function render()
    {
 
        return view('livewire.backend.admin.components.game-management.category.create', [
            'statuses'   => GameCategoryStatus::options(),
        ]);
    }


    public function save()
    {
        $this->form->validate();

        $data = $this->form->fillables();

       

        try{

            $this->service->createData($data);

            $this->success('Game category created successfully.');

             return $this->redirect(route('admin.gm.category.index'), navigate: true);

        }catch(\Exception $e){
            Log::error("Failed to create game category: " , ['error' => $e->getMessage()]);
            $this->error('Failed to create game category  ');
        }

    }

    public function resetFrom()
    {
        $this->form->reset();
    }
}
