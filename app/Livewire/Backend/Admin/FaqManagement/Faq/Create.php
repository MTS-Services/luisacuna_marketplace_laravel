<?php

namespace App\Livewire\Backend\Admin\FaqManagement\Faq;
use App\Livewire\Forms\FaqForm;
use App\Enums\FaqStatus;
use App\Enums\FaqType;
use App\Services\FaqService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Create extends Component
{
    use WithNotification;

    public FaqForm $form;

    protected FaqService $service;

    public function boot(FaqService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = FaqStatus::ACTIVE->value;
        $this->form->type   = FaqType::BUYER->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.faq-management.faq.create', [
            'statuses' => FaqStatus::options(),
            'typeses'  => FaqType::options(),
        ]);
    }

    /**
     * Store FAQ.
     */
    public function save(): mixed
{
    $data = $this->form->validate();
    try {
        $this->service->createData($data);
        $this->success('Faq created successfully');

        return redirect()->route('admin.flm.faq.index');

    } catch (\Throwable $e) {
        $this->error('Failed to create FAQ: ' . $e->getMessage());
    }
}
}
