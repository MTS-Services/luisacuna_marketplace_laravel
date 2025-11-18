<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameServer;

use App\Enums\GameServerStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameServerForm;
use App\Models\GameServer;
use App\Services\GameServerService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
 use WithNotification, WithFileUploads;

    public GameServerForm $form;
    public GameServer $data;
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
    public function mount(GameServer $data): void
    {
        $this->form->setData($data);
        $this->data = $data;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.game-server.edit', [
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
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.gm.server.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function cancel(): void
    {
        $this->form->reset();

        $this->redirect(route('admin.gm.server.index'), navigate: true);
    }
}
