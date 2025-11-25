<?php

namespace App\Livewire\Backend\Admin\GameManagement\Tag;

use App\Enums\TagStatus;
use App\Livewire\Forms\TagForm;
use App\Models\Tag;
use App\Services\TagService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithNotification, WithFileUploads;
    public Tag $data;
    public TagForm $form;
    public ?string $existingFile;
    protected TagService $service;

    public function boot(TagService $service)
    {
        $this->service = $service;
    }

    public function mount(Tag $data)
    {
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->icon;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.tag.edit', [
            'statuses' => TagStatus::options(),
        ]);
    }



    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;

            $this->data = $this->service->updateData($this->data->id, $data);


            $this->success('Data updated successfully');

            return $this->redirect(route('admin.gm.tag.index'), navigate: true);

        } catch (\Exception $e) {
            Log::error('Failed to update Data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update Data: ' . $e->getMessage());
        }
    }


    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->data);
        // Reset existing files display
        $this->existingFile = $this->data->icon;
        $this->dispatch('file-input-reset');
    }
}
