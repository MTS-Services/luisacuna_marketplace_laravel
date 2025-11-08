<?php

namespace App\Livewire\Forms\Backend\Admin\Settings;

use App\Enums\LanguageDirection;
use App\Enums\LanguageStatus;
use App\Models\Language;
use Livewire\Attributes\Locked;
use Livewire\Form;

class LanguageForm extends Form
{
     #[Locked]
    public ?int $id = null;
    public string $locale = '';
    public string $country_code = '';

    public string $name = '';

    public string $native_name = '';

    public string $flag_icon = '';

    public string $status = '';

    public int $is_default = 0;

    public string $direction = '';

    /**
     * Validation rules (handles create/update logic)
     */
    public function rules(): array
    {
        $localeRule = $this->isUpdating()
            ? 'required|string|max:10|unique:languages,locale,' . $this->id
            : 'required|string|max:10|unique:languages,locale';

        $nameRule = $this->isUpdating()
            ? 'required|string|max:50|unique:languages,name,' . $this->id
            : 'required|string|max:50|unique:languages,name';

        $countryCodeRule = $this->isUpdating()
            ? 'required|string|size:2|unique:languages,country_code,' . $this->id
            : 'required|string|size:2|unique:languages,country_code';

        return [
            'locale' => $localeRule,
            'name' => $nameRule,
            'country_code' => $countryCodeRule,
            'native_name' => 'nullable|string|max:255',
            'flag_icon' => 'nullable|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(LanguageStatus::cases(), 'value')),
            'is_default' => 'boolean',
            'direction' => 'required|string|in:' . implode(',', array_column(LanguageDirection::cases(), 'value')),
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'locale.required' => 'The locale field is required.',
            'locale.unique' => 'This locale is already in use.',
            'name.required' => 'The language name is required.',
            'name.unique' => 'This language name is already taken.',
            'country_code.required' => 'The country code is required.',
            'country_code.size' => 'The country code must be exactly 2 characters (e.g., us, bd, gb).',
            'country_code.unique' => 'This country code is already in use.',
            'status.required' => 'Please select a status.',
            'direction.required' => 'Please select a text direction.',
        ];
    }

    /**
     * Fill the form fields from a Language model
     */
    public function setData(Language $data): void
    {
        $this->id = $data->id;
        $this->locale = $data->locale;
        $this->name = $data->name;
        $this->native_name = $data->native_name ?? '';
        $this->flag_icon = $data->flag_icon ?? '';
        $this->status = $data->status->value;
        $this->direction = $data->direction->value;
        $this->is_default = $data->is_default;
        $this->country_code = $data->country_code;
    }

    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->locale = '';
        $this->name = '';
        $this->native_name = '';
        $this->flag_icon = '';
        $this->status = LanguageStatus::ACTIVE->value;
        $this->is_default = false;
        $this->direction = LanguageDirection::LTR->value;
        $this->country_code = '';

        $this->resetValidation();
    }

    /**
     * Determine if the form is updating an existing record
     */
    protected function isUpdating(): bool
    {
        return !empty($this->locale);
    }
}