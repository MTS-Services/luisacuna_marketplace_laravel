<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameServer;

use App\Enums\GameServerStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameServerForm;
use App\Services\GameServerService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
   use WithNotification, WithFileUploads;

    public GameServerForm $form;

    protected GameServerService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(GameServerService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
         $this->form->status = GameServerStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.game-server.create', [
            'statuses' => GameServerStatus::options(),
        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success('Data created successfully.');
            return $this->redirect(route('admin.gm.server.index'), navigate: true);
        } catch (\Exception $e) {

            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }
}
