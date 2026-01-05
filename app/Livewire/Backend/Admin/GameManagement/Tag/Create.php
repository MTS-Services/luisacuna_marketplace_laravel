<?php

namespace App\Livewire\Backend\Admin\GameManagement\Tag;

use App\Enums\TagStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\TagForm;
use App\Services\TagService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public TagForm $form;

    protected TagService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
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
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();


        try {
            $data['created_by'] = admin()->id;

            $data['slug'] = str()->slug($data['name']);

           
            $this->service->createData($data);
           
            $this->success('Data created successfully.');

            return $this->redirect(route('admin.gm.tag.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error('Failed to create data: ' . $e->getMessage());
            $this->error('Failed to create data');
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
