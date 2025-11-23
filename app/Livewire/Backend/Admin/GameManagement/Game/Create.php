<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;



use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;


use App\Services\CategoryService;
use App\Services\PlatformService;
use App\Services\GameService;
use App\Services\RarityService;
use App\Services\ServerService;
use App\Services\TagService;
use App\Services\TypeService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public GameForm $form;

    protected GameService $service;
    protected CategoryService $categoryService;
    protected ServerService $serverService;
    protected PlatformService $platformService;
    protected RarityService $rarityService;
    protected TypeService $typeService;
    protected TagService $tagService;



    public function boot(GameService $service, CategoryService $categoryService, PlatformService $platformService, ServerService $serverService, RarityService $rarityService, TypeService $typeService, TagService $tagService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
        $this->platformService = $platformService;
        $this->serverService = $serverService;
        $this->rarityService = $rarityService;
        $this->typeService = $typeService;
        $this->tagService = $tagService;

    }
    public function render()
    {
        $platforms = $this->getPlatforms();
        $servers = $this->getServers();
        $rarities = $this->getRarities();
        $categories = $this->gameCategories();
        $types = $this->getTypes();
        $tags = $this->getTags();
        return view('livewire.backend.admin.game-management.game.create', [

            'statuses' => GameStatus::options(),
            'categories' => $categories,
            'platforms' => $platforms,
            'servers' => $servers,
            'rarities' => $rarities,
            'types' => $types,
            'tags' => $tags,
        ]);
    }

    public function getRarities(): array
    {
        return $this->rarityService->getActiveData()->pluck('name', 'id')->toArray();
    }
    protected function getServers(): array
    {
        return $this->serverService->getActiveData()->pluck('name', 'id')->toArray();
    }
    protected function getPlatforms(): array
    {
        return $this->platformService->getActiveData()->pluck('name', 'id')->toArray();
    }
    protected function gameCategories(): array
    {
        return $this->categoryService->getActiveData()->pluck('name', 'id')->toArray();
    }
    protected function getTypes(): array
    {
        return $this->typeService->getActiveData()->pluck('name', 'id')->toArray();
    }
    protected function getTags(): array
    {
        return $this->tagService->getActiveData()->pluck('name', 'id')->toArray();
    }

    public function save()
    {
        dd($this->form->toArray());
        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->resetForm();
            $this->success('Data created successfully.');
            return $this->redirect(route('admin.gm.game.index'), navigate: true);

        } catch (\Throwable $e) {
            log_error($e);
            $this->error('Failed to create game.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->dispatch('file-input-reset');
    }
}
