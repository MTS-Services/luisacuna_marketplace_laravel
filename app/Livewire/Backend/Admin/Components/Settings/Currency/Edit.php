<?php

namespace App\Livewire\Backend\Admin\Components\Settings\Currency;

use App\DTOs\Currency\UpdateDTO;
use App\Enums\CurrencyStatus;
use App\Livewire\Forms\Backend\Admin\Settings\CurrencyForm;
use App\Models\Currency;
use App\Services\CurrencyService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Edit extends Component
{
    use WithNotification;

    public CurrencyForm $form;
    public Currency $currency;

    protected CurrencyService $currencyService;

    /**
     * Inject the currencyService via the boot method.
     */
    public function boot(CurrencyService $currencyService): void
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Currency $data): void
    {
        $this->currency = $data;
        $this->form->setData($this->currency);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.components.settings.currency.edit', [
            'statuses' => CurrencyStatus::options(),
        ]);
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $this->form->validate();
        try {
            $updated = $this->currencyService->updateData($this->currency->id, $this->form->fillables());

            $this->dispatch('CurrencyUpdated');
            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.as.currency.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->setData($this->currency);
        $this->form->resetValidation();
    }
}
