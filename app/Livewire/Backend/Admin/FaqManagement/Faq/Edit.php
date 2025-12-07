<?php

namespace App\Livewire\Backend\Admin\FaqManagement\Faq;
use App\Livewire\Forms\FaqForm;
use App\Enums\FaqType;
use App\Enums\FaqStatus;
use App\Models\Faq;
use App\Services\FaqService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
class Edit extends Component
{
    use WithNotification, WithFileUploads;

    public Faq $data;
    public FaqForm $form;
    public ?string $existingFile = null;

    protected FaqService $service;

    public function boot(FaqService $service)
    {
        $this->service = $service;
    }

    public function mount(Faq $data)
    {
        $this->data = $data;


        // Ensure the form is hydrated before setting data
        $this->form->setData($data);

        // Keep existing file for displaying in UI
        $this->existingFile = $data->icon ?? null;

        $this->form->status = FaqStatus::ACTIVE->value;
        $this->form->type   = FaqType::BUYER->value;
    }

    public function render()
    {
        return view('livewire.backend.admin.faq-management.faq.edit', [
            'statuses' => FaqStatus::options(),
            'typeses'  => FaqType::options(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();

        try {
            $validated['updated_by'] = admin()->id;

            // Update the record
            $this->data = $this->service->updateData($this->data->id, $validated);

            $this->success('Data updated successfully');

            return $this->redirect(route('admin.flm.faq.index'), navigate: true);

        } catch (\Exception $e) {
            Log::error('Failed to update FAQ', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error('Failed to update Data: ' . $e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->data);

        $this->existingFile = $this->data->icon ?? null;

        // Reset Livewire file input
        $this->dispatch('file-input-reset');
    }
}
