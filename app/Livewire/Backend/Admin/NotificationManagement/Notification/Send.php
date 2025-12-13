<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Services\NotificatonService;
use App\Enums\CustomNotificationType;
use App\Livewire\Forms\NotificationForm;
use App\Traits\Livewire\WithNotification;

class Send extends Component
{
    use WithFileUploads, WithNotification;

    public NotificationForm $form;

    protected NotificatonService $service;

    public function boot(NotificatonService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        return view('livewire.backend.admin.notification-management.notification.send', [
            'types' => CustomNotificationType::options()
        ]);
    }

    public function save()
    {
        $data = $this->form->validate();

        try {
            $data['created_by'] = admin()->id;

            $this->service->createData($data);

            $this->success('Data created successfully');
            return $this->redirect(route('admin.nm.notification.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error('Failed to create data: ' . $e->getMessage());
            $this->error('Failed to create data.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->dispatch('file-input-reset');
    }
}
