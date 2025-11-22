<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;



use App\Enums\GameStatus;
use App\Enums\GameTag as EnumsGameTag;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;


use App\Services\CategoryService;
use App\Services\PlatformService;
use App\Services\GameService;
use App\Services\RarityService;
use App\Services\ServerService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    protected GameService $service;

    public GameForm $form;

    protected CategoryService $categoryService;

    protected ServerService $serverService;

    protected PlatformService $platformService;

    protected RarityService $rarityService;

    public function boot(GameService $service, CategoryService $categoryService, PlatformService $platformService, ServerService $serverService , RarityService $rarityService)
    {
        $this->service = $service;

        $this->categoryService = $categoryService;

        $this->platformService = $platformService;

        $this->serverService = $serverService;

        $this->rarityService = $rarityService;

    }
    public function render()
    {
        $platforms = $this->getPlatforms();

        $servers = $this->getServers();

        $rarities = $this->getRarities();
        return view('livewire.backend.admin.game-management.game.create', [

            'statuses' => GameStatus::options(),

            'categories' => $this->gameCategories(),

            'platforms' => $platforms,

            'servers' => $servers,

            'tags' => EnumsGameTag::options(),

            'rarities' => $rarities ,
        ]);
    }

    public function getRarities(): array {

      return  $this->rarityService->getActiveData()->pluck('name', 'id')->toArray();

    }
    protected function getServers() : array
    {
        return $this->serverService->getActiveData()->pluck('name', 'id')->toArray();
    }
    protected function getPlatforms(): array
    {
        return $this->platformService->getAllDatas()->pluck('name', 'id')->toArray();
    }
    protected function gameCategories(): array
    {
        return $this->categoryService->getActiveData()->pluck('name', 'id')->toArray();
    }

    public function save()
    {

       $data =  $this->form->validate();

        try {

           

            $data['created_by'] = admin()->id;

           

            $this->service->createData($data);

            $this->resetForm();

            $this->success('Game created successfully.');

            return $this->redirect(route('admin.gm.game.index'), navigate: true);

        } catch (\Throwable $th) {

            Log::error("Failed to create game: ", ['error' => $th->getMessage()]);
            $this->error('Failed to create game.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->dispatch('file-input-reset');
    }
}
