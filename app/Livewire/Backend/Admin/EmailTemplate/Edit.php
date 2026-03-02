<?php

namespace App\Livewire\Backend\Admin\EmailTemplate;

use App\Livewire\Forms\Backend\Admin\EmailManagement\TemplateUpdateForm;
use App\Models\EmailTemplate;
use App\Services\EmailTemplateService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Edit extends Component
{
    use WithNotification;

    public TemplateUpdateForm $form;
    public EmailTemplate $template;

    public array $variables = [];

    protected EmailTemplateService $emailTemplate;

    public function boot(EmailTemplateService $emailTemplate): void
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function mount(string $id): void
    {
        try {
            $decryptedId = (int) decrypt($id);
            $this->template = $this->emailTemplate->find($decryptedId);
            if ($this->template === null) {
                $this->redirect(route('admin.email-template.index'), navigate: true);

                return;
            }
            $this->variables = $this->template->variables ?? [];
            $this->form->setData($this->template);
        } catch (\Exception $e) {
            Log::error('Failed to load template', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error(__('Failed to load template.'));
            $this->redirect(route('admin.email-template.index'), navigate: true);
        }
    }


    public function save(): void
    {
        $data = $this->form->validate();
        try {
            $this->emailTemplate->update($this->template->id, $data);
            $this->success(__('Template updated successfully'));
            $this->redirect(route('admin.email-template.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error(__('Failed to update template'));
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->template);
        $this->dispatch('reset-tinymce-initiallized');
    }

    public function render()
    {
        return view('livewire.backend.admin.email-template.edit');
    }
}
