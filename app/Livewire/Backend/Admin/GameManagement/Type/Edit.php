<?php

namespace App\Livewire\Backend\Admin\GameManagement\Type;

use App\Enums\TypeStatus;
use App\Livewire\Forms\TypeForm;
use App\Models\Type;
use App\Services\TypeService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;
class Edit extends Component
{

    use WithNotification, WithFileUploads;
    public Type $data;
    public TypeForm $form;
    public ?string $existingFile;
    protected TypeService $service;

    public function boot(TypeService $service)
    {
        $this->service = $service;
    }

    public function mount(Type $data)
    {
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->icon;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.type.edit', [
            'statuses' => TypeStatus::options(),
        ]);
    }



    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;

            $this->data = $this->service->updateData($this->data->id, $data);


            $this->success('Data updated successfully');

            return $this->redirect(route('admin.gm.type.index'), navigate: true);

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
