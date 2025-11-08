<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\DTOs\Language\UpdateLanguageDTO;
use App\Enums\LanguageDirection;
use App\Enums\LanguageStatus;
use App\Livewire\Forms\Backend\Admin\Settings\LanguageForm;
use App\Models\Language;
use App\Services\LanguageService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Edit extends Component
{
    use WithNotification;

    public LanguageForm $form;
    public Language $data;

    protected LanguageService $service;

    /**
     * Inject the LanguageService via the boot method.
     */
    public function boot(LanguageService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Language $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.settings.language.edit', [
            'statuses' => LanguageStatus::options(),
            'directions' => LanguageDirection::options(),
        ]);
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $validated = $this->form->validate();
        try {

            $flagIcon = null;
            if (!empty($validated['country_code'])) {
                $flagIcon = 'https://flagcdn.com/' . strtolower($validated['country_code']) . '.svg';
            }
            $data = array_merge($validated, [
                'flag_icon' => $flagIcon,
                'updated_by' => admin()->id,
            ]);


            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.as.language.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update Data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
       public function resetForm(): void
    {
        $this->form->setData($this->data);
        $this->form->resetValidation();
    }
}
