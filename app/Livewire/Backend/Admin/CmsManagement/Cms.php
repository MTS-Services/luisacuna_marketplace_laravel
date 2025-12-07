<?php

namespace App\Livewire\Backend\Admin\CmsManagement;

use App\Enums\CmsType;
use Livewire\Component;
use App\Services\CmsService;
use App\Livewire\Forms\CmsForm;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;

class Cms extends Component
{
    use WithNotification;

    public CmsForm $form;
    public $type;
    public $typeEnum;

    protected CmsService $service;

    public function boot(CmsService $service)
    {
        $this->service = $service;
    }

    public function mount($type)
    {
        $this->type = $type;
        $this->typeEnum = CmsType::from($type);
        $this->loadCmsData();
    }

    public function loadCmsData()
    {
        $cms = $this->service->getByType($this->type);

        if ($cms) {
            $this->form->setData($cms);
        } else {
            $this->form->reset();
        }
    }
    public function render()
    {
        return view('livewire.backend.admin.cms-management.cms');
    }

    public function save()
    {
        $data = $this->form->validate();

        try {
            $data['updated_by'] = admin()->id;

            $this->service->updateByType($this->type, $data);

            $this->success($this->typeEnum->label() . ' updated successfully!');

            $this->loadCmsData();
        } catch (\Exception $e) {
            Log::error('CMS Update Error: ' . $e->getMessage(), [
                'type' => $this->type,
                'content_length' => strlen($data['content'] ?? ''),
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Failed to update ' . $this->typeEnum->label() . '. Please check logs.');
        }
    }

    public function resetFrom(): void
    {
        $this->loadCmsData();
        $this->dispatch('file-input-reset');
    }
}
