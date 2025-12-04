<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\CategoryStatus;
use App\Enums\GameStatus;
use App\Livewire\Forms\GameForm;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Traits\Livewire\WithNotification;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Store extends Component
{

    use WithFileUploads, WithNotification;

    public GameForm $form;

    protected GameService $service;
    protected CategoryService $categoryService;

    public function boot(GameService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    public function render()
    {
        $categories = $this->categoryService->getDatas(sortField: 'name', order: 'asc', status: CategoryStatus::ACTIVE->value)->pluck('name', 'id');
        return view('livewire.backend.admin.game-management.game.store', [
            'statuses' => GameStatus::options(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();
        try {
            $this->service->create($validated);
            $this->success('Move to next step.');
            return $this->redirect(route('admin.gm.game.index'), navigate: true);
        } catch (Exception $e) {
            Log::error('Failed to create game: ' . $e->getMessage());
            $this->error('Something went wrong. Please try again.');
        }
    }
}
