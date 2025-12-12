<?php

namespace App\Livewire\Forms;

use App\Enums\CustomNotificationType;
use App\Models\CustomNotification;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;
use Livewire\Form;

class NotificationForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public string $send_to = 'users';
    public ?int $user_id = null;
    public ?string $title = null;
    public ?string $message = null;
    public ?string $description = null;
    public string $icon = 'bell-ring';
    public ?string $action = null;
     public ?string $type = CustomNotificationType::PUBLIC->value;

    public function rules(): array
    {
        $rules = [
            'send_to' => 'required|string|in:users,admins,public',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'action' => 'nullable|url',
            'type' => 'required|string|in:' . implode(',', array_column(CustomNotificationType::cases(), 'value')),
        ];

        // user_id validation - send_to er upor depend kore
        if ($this->send_to === 'users') {
            $rules['user_id'] = 'nullable|integer|exists:users,id';
        } elseif ($this->send_to === 'admins') {
            $rules['user_id'] = 'nullable|integer|exists:admins,id';
        }

        return $rules;
    }

    public function validationAttributes(): array
    {
        return [
            'send_to' => 'send to',
            'user_id' => 'user/admin ID',
            'title' => 'title',
            'message' => 'message',
            'description' => 'description',
            'icon' => 'icon',
            'action' => 'action URL',
        ];
    }

    public function messages(): array
    {
        return [
            'send_to.required' => 'Please select who to send the notification to.',
            'send_to.in' => 'Invalid send to option selected.',
            'user_id.exists' => 'The selected user does not exist.',
            'title.required' => 'Notification title is required.',
            'message.required' => 'Notification message is required.',
            'action.url' => 'Please provide a valid URL for the action.',
        ];
    }

    public function setData(CustomNotification $data)
    {
        $this->id = $data->id;
        
       $this->type = $data->type->value ?? null;

        $this->user_id = $data->receiver_id ?? null;
        
        // Data JSON theke extract kora
        $notificationData = is_string($data->data) ? json_decode($data->data, true) : $data->data;
        
        $this->title = $notificationData['title'] ?? null;
        $this->message = $notificationData['message'] ?? null;
        $this->description = $notificationData['description'] ?? null;
        $this->icon = $notificationData['icon'] ?? 'bell-ring';
        $this->action = $data->action ?? null;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->send_to = 'users';
        $this->user_id = null;
        $this->title = null;
        $this->message = null;
        $this->description = null;
        $this->icon = 'bell-ring';
        $this->action = null;
         $this->type = null;

        $this->resetValidation();
    }

    public function isUpdating(): bool
    {
        return isset($this->id);
    }

    /**
     * Form data array hisebe return kora (service e pathano jonno)
     */
    public function toArray(): array
    {
        return [
            'send_to' => $this->send_to,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'message' => $this->message,
            'description' => $this->description,
            'icon' => $this->icon,
            'action' => $this->action,
        ];
    }

    /**
     * Send to change hole user_id null kore dewa
     */
    public function updatedSendTo(): void
    {
        $this->user_id = null;
        $this->resetValidation('user_id');
    }
}