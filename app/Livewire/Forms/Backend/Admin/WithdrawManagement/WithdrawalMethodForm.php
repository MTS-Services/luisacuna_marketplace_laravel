<?php

namespace App\Livewire\Forms\Backend\Admin\WithdrawManagement;

use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class WithdrawalMethodForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public string $name = '';

    public string $code = '';

    public string $description = '';

    public string $status = '';

    public string $min_amount = '';

    public string $max_amount = '';

    public string $daily_limit = '';

    public string $weekly_limit = '';

    public string $monthly_limit = '';

    public string $processing_time = '';

    public string $fee_type = '';

    public string $fee_amount = '';

    public string $fee_percentage = '';

    public array $required_fields = [];

    public ?UploadedFile $icon = null;

    // Track removed files (create & update parity)
    public bool $remove_icon = false;

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:100|unique:withdrawal_methods,name'.($this->isUpdating() ? ','.$this->id : ''),
            'code' => 'required|string|max:50|unique:withdrawal_methods,code'.($this->isUpdating() ? ','.$this->id : ''),
            'description' => 'nullable|string',
            'status' => 'required|string|in:'.implode(',', array_column(ActiveInactiveEnum::cases(), 'value')),
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'nullable|numeric|gt:min_amount',
            'daily_limit' => 'nullable|numeric|min:0',
            'weekly_limit' => 'nullable|numeric|min:0',
            'monthly_limit' => 'nullable|numeric|min:0',
            'processing_time' => 'nullable|string|max:100',
            'fee_type' => 'required|string|in:'.implode(',', array_column(WithdrawalFeeType::cases(), 'value')),
            'fee_amount' => 'nullable|numeric|min:0',
            'fee_percentage' => 'nullable|numeric|min:0|max:100',
            'required_fields' => 'nullable|array',
            'required_fields.*.label' => 'required|string|max:255',
            'required_fields.*.name' => 'required|string|max:255',
            'required_fields.*.input_type' => 'required|string',
            'required_fields.*.validation' => 'required|in:required,optional',
            'required_fields.*.placeholder' => 'nullable|string|max:255',
            'required_fields.*.options' => 'nullable|string',
            'required_fields.*.help_text' => 'nullable|string|max:500',
            'icon' => 'nullable|image|max:2048',
            'remove_icon' => 'nullable|boolean',
        ];

        return $rules;
    }

    public function setData($withdrawalMethod): void
    {
        $this->id = $withdrawalMethod->id;
        $this->name = $withdrawalMethod->name ?? '';
        $this->code = $withdrawalMethod->code ?? '';
        $this->description = $withdrawalMethod->description ?? '';
        $this->status = $withdrawalMethod->status->value ?? ActiveInactiveEnum::ACTIVE->value;
        $this->min_amount = $withdrawalMethod->min_amount ?? '';
        $this->max_amount = $withdrawalMethod->max_amount ?? '';
        $this->daily_limit = $withdrawalMethod->daily_limit ?? '';
        $this->weekly_limit = $withdrawalMethod->weekly_limit ?? '';
        $this->monthly_limit = $withdrawalMethod->monthly_limit ?? '';
        $this->processing_time = $withdrawalMethod->processing_time ?? '';
        $this->fee_type = $withdrawalMethod->fee_type->value ?? WithdrawalFeeType::FIXED->value;
        $this->fee_amount = $withdrawalMethod->fee_amount ?? '';
        $this->fee_percentage = $withdrawalMethod->fee_percentage ?? '';

        // Convert required_fields from JSON to array for editing
        $this->required_fields = is_string($withdrawalMethod->required_fields)
            ? json_decode($withdrawalMethod->required_fields, true) ?? []
            : ($withdrawalMethod->required_fields ?? []);
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->status = ActiveInactiveEnum::ACTIVE->value;
        $this->min_amount = '';
        $this->max_amount = '';
        $this->daily_limit = '';
        $this->weekly_limit = '';
        $this->monthly_limit = '';
        $this->processing_time = '';
        $this->fee_type = WithdrawalFeeType::FIXED->value;
        $this->fee_amount = '';
        $this->fee_percentage = '';
        $this->required_fields = [];
        $this->icon = null;
        $this->remove_icon = false;
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return ! empty($this->id);
    }

    protected function emptyStringToNull(mixed $value): mixed
    {
        return $value === '' ? null : $value;
    }

    public function fillables(): array
    {
        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status,
            'min_amount' => $this->min_amount,
            'max_amount' => $this->emptyStringToNull($this->max_amount),
            'daily_limit' => $this->emptyStringToNull($this->daily_limit),
            'weekly_limit' => $this->emptyStringToNull($this->weekly_limit),
            'monthly_limit' => $this->emptyStringToNull($this->monthly_limit),
            'processing_time' => $this->processing_time,
            'fee_type' => $this->fee_type,
            'fee_amount' => $this->emptyStringToNull($this->fee_amount),
            'fee_percentage' => $this->emptyStringToNull($this->fee_percentage),
            'required_fields' => $this->processRequiredFields(),
            'icon' => $this->icon,
            'remove_icon' => $this->remove_icon,
        ];

        return $data;
    }

    protected function processRequiredFields(): array
    {
        if (empty($this->required_fields)) {
            return [];
        }

        return collect($this->required_fields)->map(function ($field) {
            // Remove the 'id' field used by Alpine for tracking
            unset($field['id']);

            // Process options for select, radio, checkbox
            if (! empty($field['options']) && in_array($field['input_type'], ['select', 'radio', 'checkbox'])) {
                // If it's already an array, keep it; otherwise split by comma
                if (is_string($field['options'])) {
                    $field['options'] = array_map('trim', explode(',', $field['options']));
                }
            } else {
                unset($field['options']);
            }

            // Clean up empty values
            return array_filter($field, function ($value) {
                return $value !== null && $value !== '' && $value !== false;
            });
        })->values()->toArray();
    }

    public function all(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status,
            'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount,
            'daily_limit' => $this->daily_limit,
            'weekly_limit' => $this->weekly_limit,
            'monthly_limit' => $this->monthly_limit,
            'processing_time' => $this->processing_time,
            'fee_type' => $this->fee_type,
            'fee_amount' => $this->fee_amount,
            'fee_percentage' => $this->fee_percentage,
            'required_fields' => $this->required_fields,
            'icon' => $this->icon,
        ];
    }
}
