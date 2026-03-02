<?php

namespace App\Livewire\Backend\Admin\EmailTemplate;

use App\Services\EmailTemplateService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected EmailTemplateService $emailTemplateService;

    public function boot(EmailTemplateService $emailTemplateService): void
    {
        $this->emailTemplateService = $emailTemplateService;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $templates = $this->emailTemplateService->paginateDatas(12, [
            'search' => $this->search ?: null,
        ]);

        return view('livewire.backend.admin.email-template.index', [
            'templates' => $templates,
        ]);
    }
}
