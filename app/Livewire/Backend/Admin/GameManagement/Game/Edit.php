<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;
use App\Models\Game;
use App\Models\GamePlatform;
use App\Services\GameCategoryService;
use App\Services\GamePlatformService;
use App\Services\GameService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;
    public Game $game;
    public GameForm $form;
    protected GameCategoryService $categoryService;

    protected GameService $service;

    protected GamePlatformService $gamePlatformService;
    public $data = null;

    public function boot(GameCategoryService $categoryService, GameService $service, GamePlatformService $gamePlatformService)
    {

        $this->categoryService = $categoryService;

        $this->service = $service;

        $this->gamePlatformService = $gamePlatformService;
    }
    public function mount(Game $data)
    {

        $this->form->setData($data);

        $this->data = $data;
    }

    public function render()
    {
       
        return view('livewire.backend.admin.game-management.game.edit', [

            'statuses'   => GameStatus::options(),
            'categories' => $this->categories(),
            'platforms'  => $this->getPlatforms(),
        ]);
    }

       protected function getPlatforms(): array
    {
        return $this->gamePlatformService->getActiveData()->pluck('name', 'id')->toArray();
    }

    protected function categories()
    {
        return $this->categoryService->getActiveData()->pluck('name', 'id')->toArray();
    }


    public function save()
    {

        $this->form->validate();

        try {
            $data = $this->form->fillables();

            $data['updater_id'] = admin()->id;
            $data['upater_type'] = get_class(admin());

            $this->service->updateData($this->data->id, $data);

            $this->form->reset();

            $this->success('Game updated successfully.');

            return $this->redirect(route('admin.gm.game.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to update game: ', ['error' => $e->getMessage()]);
            $this->error('Failed to update game');
            return;
        }
    }

    public function cancel()
    {

        return $this->redirect(route('admin.gm.game.index'), navigate: true);
    }
}
