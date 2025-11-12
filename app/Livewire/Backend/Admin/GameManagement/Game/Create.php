<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;



use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;
use App\Models\GamePlatform;
use App\Services\GameCategoryService;
use App\Services\GamePlatformService;
use App\Services\GameService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    protected GameService $service;

    public GameForm $form;

    protected GameCategoryService $categoryService;

    protected GamePlatformService $gamePlatformService;

    public function boot(GameService $service,  GameCategoryService $categoryService, GamePlatformService $gamePlatformService)
    {
        $this->service = $service;

        $this->categoryService = $categoryService;

        $this->gamePlatformService = $gamePlatformService;
    }
    public function render()
    {
        $platforms = $this->getPlatforms();

        return view('livewire.backend.admin.game-management.game.create', [

            'statuses'   => GameStatus::options(),

            'categories' => $this->gameCategory(),

            'platforms' => $platforms

        ]);
    }

    protected function getPlatforms(): array
    {
        return $this->gamePlatformService->getAllDatas()->pluck('name', 'id')->toArray();
    }
    protected function gameCategory(): array
    {
        return $this->categoryService->getActiveData()->pluck('name', 'id')->toArray();
    }

    public function save()
    {

        $this->form->validate();


        try {

            $data = $this->form->fillables();

            $data['creater_id'] = admin()->id;

            $data['creater_type'] = get_class(admin());

            $this->service->createData($data);

            $this->resetForm();

            $this->success('Game created successfully.');

            return $this->redirect(route('admin.gm.game.index'), navigate: true);
            
        } catch (\Throwable $th) {

            Log::error("Failed to create game: ", ['error' => $th->getMessage()]);
            $this->error('Failed to create game.');
        }
    }

    public function resetForm()
    {
        $this->form->reset();
    }
}
