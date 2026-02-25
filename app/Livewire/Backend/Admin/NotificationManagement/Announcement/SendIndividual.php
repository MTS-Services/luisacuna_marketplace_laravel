<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Announcement;

use App\Enums\CustomNotificationType;
use App\Livewire\Forms\AnnouncementForm;
use App\Models\Admin;
use App\Models\User;
use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SendIndividual extends Component
{
    use WithNotification;

    public AnnouncementForm $form;

    public int $step = 1;

    public ?string $recipientType = null;

    public string $recipientSearch = '';

    public ?int $receiver_id = null;

    public ?string $receiver_type = null;

    public string $receiver_name = '';

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->resetForm();
    }

    public function setRecipientType(string $type): void
    {
        if (! in_array($type, ['admin', 'user'], true)) {
            return;
        }
        $this->recipientType = $type;
        $this->recipientSearch = '';
        $this->receiver_id = null;
        $this->receiver_type = null;
        $this->receiver_name = '';
        $this->step = 2;
        $this->resetValidation();
    }

    public function setRecipientTypeAdmin(): void
    {
        $this->setRecipientType('admin');
    }

    public function setRecipientTypeUser(): void
    {
        $this->setRecipientType('user');
    }

    public function selectRecipient(int $id, string $type): void
    {
        $modelClass = $type === 'admin' ? Admin::class : User::class;
        $model = $modelClass::find($id);
        if (! $model) {
            return;
        }
        $this->receiver_id = $model->getKey();
        $this->receiver_type = $modelClass;
        $this->receiver_name = $model->name ?? $model->full_name ?? trim(($model->first_name ?? '').' '.($model->last_name ?? '')) ?: $model->email ?? (string) $id;
        $this->step = 3;
    }

    public function backToStepOne(): void
    {
        $this->step = 1;
        $this->recipientType = null;
        $this->recipientSearch = '';
        $this->receiver_id = null;
        $this->receiver_type = null;
        $this->receiver_name = '';
        $this->resetValidation();
    }

    public function backToStepTwo(): void
    {
        $this->step = 2;
        $this->receiver_id = null;
        $this->receiver_type = null;
        $this->receiver_name = '';
        $this->resetValidation();
    }

    public function save(): void
    {
        if (! $this->receiver_id || ! $this->receiver_type) {
            $this->addError('receiver', __('Please select a recipient.'));

            return;
        }

        $this->form->type = $this->recipientType === 'admin'
            ? CustomNotificationType::ADMIN->value
            : CustomNotificationType::USER->value;

        $data = $this->form->validate();

        if (! empty($data['action']) && ! preg_match('/^https?:\/\//', $data['action'])) {
            $data['action'] = 'https://'.$data['action'];
        }

        if (! empty($data['additional'])) {
            $data['additional'] = array_filter($data['additional'], function ($value, $key) {
                return ! empty(trim((string) $key)) && ! empty(trim((string) $value));
            }, ARRAY_FILTER_USE_BOTH);
        }

        try {
            $data['sender_id'] = admin()->id;
            $data['sender_type'] = Admin::class;
            $data['receiver_id'] = $this->receiver_id;
            $data['receiver_type'] = $this->receiver_type;
            $data['is_announced'] = true;
            $data['icon'] = 'megaphone';

            $this->service->create($data);

            $this->success(__('Announcement sent successfully'));
            $this->dispatch('individual-announcement-modal-close');
            $this->resetForm();
            $this->dispatch('refresh-announcement-list');
        } catch (\Exception $e) {
            Log::error('Failed to send individual announcement: '.$e->getMessage());
            $this->error(__('Failed to send announcement. Please try again.'));
        }
    }

    public function resetForm(): void
    {
        $this->step = 1;
        $this->recipientType = null;
        $this->recipientSearch = '';
        $this->receiver_id = null;
        $this->receiver_type = null;
        $this->receiver_name = '';
        $this->form->reset();
        $this->form->additional = [];
        $this->form->type = CustomNotificationType::USER->value;
        $this->resetValidation();
    }

    protected function getSearchResults(): Collection
    {
        $q = trim($this->recipientSearch);
        if ($this->recipientType === 'admin') {
            return $this->searchAdmins($q);
        }
        if ($this->recipientType === 'user') {
            return $this->searchUsers($q);
        }

        return collect();
    }

    protected function searchAdmins(string $query): Collection
    {
        $builder = Admin::query()->active();
        if ($query !== '') {
            $builder->where(function ($q) use ($query) {
                $like = '%'.$query.'%';
                $q->where('first_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)
                    ->orWhere('email', 'like', $like);
            });
        }

        return $builder->orderBy('first_name')->orderBy('last_name')->limit(15)->get();
    }

    protected function searchUsers(string $query): Collection
    {
        $builder = User::query();
        if ($query !== '') {
            $builder->where(function ($q) use ($query) {
                $like = '%'.$query.'%';
                $q->where('first_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('username', 'like', $like);
            });
        }

        return $builder->orderBy('first_name')->orderBy('last_name')->limit(15)->get();
    }

    public function render(): View
    {
        $recipients = $this->step === 2 && $this->recipientType
            ? $this->getSearchResults()
            : collect();

        return view('livewire.backend.admin.notification-management.announcement.send-individual', [
            'recipients' => $recipients,
        ]);
    }
}
