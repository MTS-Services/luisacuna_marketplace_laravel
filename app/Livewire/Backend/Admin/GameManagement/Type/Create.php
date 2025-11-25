<?php

namespace App\Livewire\Backend\Admin\GameManagement\Type;

use App\Enums\TypeStatus;
use App\Livewire\Forms\TypeForm;
use App\Services\TypeService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
class Create extends Component
{
    use WithNotification, WithFileUploads;

    public TypeForm $form;
    protected TypeService $service;



    public function boot(TypeService $service): void
    {

        $this->service = $service;

    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = TypeStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.type.create', [

            'statuses' => TypeStatus::options(),

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

            return $this->redirect(route('admin.gm.type.index'), navigate: true);

        } catch (\Throwable $e) {
            log_error($e);
            $this->error('Failed to create data');
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
        $this->dispatch('file-input-reset');
    }
}
