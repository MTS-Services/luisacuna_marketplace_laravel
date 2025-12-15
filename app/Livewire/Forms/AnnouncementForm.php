<?php

namespace App\Livewire\Forms;

use App\Enums\CustomNotificationType;
use App\Models\CustomNotification;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;
use Livewire\Form;

class AnnouncementForm extends Form
{
    public ?string $title = null;
    public ?string $message = null;
    public ?string $type = CustomNotificationType::PUBLIC->value;
    public ?string $action = null;
    public ?string $description = null;
    public ?array $additional = [];


    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'description' => 'nullable|string',
            'additional' => 'nullable|array',
            'additional.*' => 'nullable|string',
            'action' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (empty($value)) {
                        return;
                    }

                    // If it doesn't start with http:// or https://, add https://
                    $url = $value;
                    if (!preg_match('/^https?:\/\//', $value)) {
                        $url = 'https://' . $value;
                    }

                    // Validate the complete URL
                    if (!filter_var($url, FILTER_VALIDATE_URL)) {
                        $fail('The action field must be a valid URL.');
                    }
                },
            ],
            'type' => 'required|string|in:' . implode(',', array_column(CustomNotificationType::cases(), 'value')),
        ];
        return $rules;
    }

    public function reset(...$properties): void
    {
        $this->title = null;
        $this->message = null;
        $this->additional = [];
        $this->description = null;
        $this->type = CustomNotificationType::PUBLIC->value;
        $this->action = null;

        $this->resetValidation();
    }
}
