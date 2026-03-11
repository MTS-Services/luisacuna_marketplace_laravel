<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\Enums\LanguageStatus;
use App\Services\LanguageService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Index extends Component
{
    use WithNotification;

    protected $listeners = [
        'languageCreated' => '$refresh',
        'languageUpdated' => '$refresh',
    ];

    protected LanguageService $service;

    public function boot(LanguageService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $languages = $this->service
            ->getAllDatas()
            ->load('creater_admin');

        return view('livewire.backend.admin.settings.language.index', [
            'languages' => $languages,
        ]);
    }

    public function changeStatus($id, $status): void
    {
        try {
            $languageStatus = LanguageStatus::from($status);

            $this->service->updateStatusData((int) $id, $languageStatus);

            $this->success('Language status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: '.$e->getMessage());
        }
    }
}
