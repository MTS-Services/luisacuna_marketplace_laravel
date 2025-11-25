<?php

namespace App\Livewire\Backend\Admin\GameManagement\Tag;

use App\Enums\TagStatus;
use App\Livewire\Forms\TagForm;
use App\Services\TagService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
class Create extends Component
{
    use WithNotification, WithFileUploads;

    public TagForm $form;
    protected TagService $service;



    public function boot(TagService $service): void
    {

        $this->service = $service;

    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = TagStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.tag.create', [

            'statuses' => TagStatus::options(),

        ]);
    }

    /**
     * Handle form submission to create a new tag.
     */
    public function save()
    {
        $data = $this->form->validate();


        try {

            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success('Data created successfully.');

            return $this->redirect(route('admin.gm.tag.index'), navigate: true);

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
