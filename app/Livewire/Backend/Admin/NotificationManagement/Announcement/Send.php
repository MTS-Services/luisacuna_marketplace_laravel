<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Announcement;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Services\NotificatonService;
use App\Enums\CustomNotificationType;
use App\Livewire\Forms\AnnouncementForm;
use App\Models\Admin;
use App\Traits\Livewire\WithNotification;

class Send extends Component
{
    use WithFileUploads, WithNotification;

    public AnnouncementForm $form;

    protected NotificatonService $service;

    public function boot(NotificatonService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->form->reset();
        $this->form->additional = [];
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.backend.admin.notification-management.announcement.send', [
            'types' => CustomNotificationType::options()
        ]);
    }

    public function save()
    {
        $data = $this->form->validate();

        // Auto-prepend https:// if not present
        if (!empty($data['action']) && !preg_match('/^https?:\/\//', $data['action'])) {
            $data['action'] = 'https://' . $data['action'];
        }

        // Filter out empty additional notes
        if (!empty($data['additional'])) {
            $data['additional'] = array_filter($data['additional'], function ($note) {
                return !empty(trim($note));
            });
            $data['additional'] = array_values($data['additional']);
        }

        try {
            $data['sender_id'] = admin()->id;
            $data['sender_type'] = Admin::class;
            $data['is_announced'] = true;
            $data['icon'] = 'megaphone';

            $this->service->createData($data);

            $this->success('Announcement sent successfully');

            // Close modal and reset form
            $this->dispatch('announcement-modal-close');
            $this->resetForm();

            // Refresh the index table
            $this->dispatch('refresh-announcement-list');
        } catch (\Exception $e) {
            Log::error('Failed to send announcement: ' . $e->getMessage());
            $this->error('Failed to send announcement. Please try again.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->additional = [];
        $this->resetValidation();
    }
}
