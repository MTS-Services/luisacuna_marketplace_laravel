<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\CategoryStatus;
use App\Enums\GameStatus;
use App\Livewire\Forms\GameForm;
use App\Models\Game;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Traits\Livewire\WithNotification;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Store extends Component
{

    use WithFileUploads, WithNotification;

    public GameForm $form;

    protected GameService $service;
    protected CategoryService $categoryService;

    public ?string $existing_logo = null;
    public ?string $existing_banner = null;

    // hide the game from snapshot in blade file 
    public ?Game $data = null;

    public function boot(GameService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    public function mount(?Game $data = null)
    {
        if ($data && !$data->exists) {
            $data = null;
        }
        $this->data = $data;
        if ($data !== null) {
            $this->form->setData($data);
            $this->existing_logo = $data->logo;
            $this->existing_banner = $data->banner;
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.game-management.game.store', [
            'statuses' => GameStatus::options(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();
        try {
            if ($this->data) {
                $this->service->update($this->data->id, $validated);
                $this->success('Move to next step.');
                return $this->redirect(route('admin.gm.game.config', encrypt($this->data->id)), navigate: true);
            } else {
                $data = $this->service->create($validated);
                $this->success('Move to next step.');
                return $this->redirect(route('admin.gm.game.config', encrypt($data->id)), navigate: true);
            }
        } catch (Exception $e) {
            Log::error('Failed to create game: ' . $e->getMessage());
            $this->error('Something went wrong. Please try again.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        if ($this->data) {
            $this->form->setData($this->data);
            $this->existing_logo = $this->data->logo;
            $this->existing_banner = $this->data->banner;
        }
        $this->dispatch('file-input-reset');
    }
}
