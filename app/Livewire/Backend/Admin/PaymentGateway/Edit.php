<?php

namespace App\Livewire\Backend\Admin\PaymentGateway;

use App\Enums\MethodModeStatus;
use App\Models\PaymentGateway;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Edit extends Component
{
    public bool  $modalShow     = false;
    public bool  $isLoading     = false;
    public ?int  $gatewayId     = null;

    public string $editName     = '';
    public string $editMode     = 'sandbox';
    public bool   $editIsActive = true;

    /** @var array<string, string> */
    public array $editLiveData    = [];

    /** @var array<string, string> */
    public array $editSandboxData = [];

    public function openEdit(int $id): void
    {
        $this->isLoading = true;

        $gateway = PaymentGateway::findOrFail($id);

        $this->gatewayId    = $gateway->id;
        $this->editName     = $gateway->name;
        $this->editMode     = $gateway->mode?->value ?? 'sandbox';
        $this->editIsActive = $gateway->is_active;

        $fields      = $this->credentialFields()[$gateway->slug] ?? [];
        $liveData    = $gateway->live_data    ?? [];
        $sandboxData = $gateway->sandbox_data ?? [];

        $this->editLiveData    = [];
        $this->editSandboxData = [];

        foreach ($fields as $field) {
            $this->editLiveData[$field['key']]    = $liveData[$field['key']]    ?? '';
            $this->editSandboxData[$field['key']] = $sandboxData[$field['key']] ?? '';
        }

        $this->isLoading = false;
    }

    public function closeModal(): void
    {
        $this->modalShow  = false;
        $this->gatewayId  = null;
        $this->isLoading  = false;
        $this->reset(['editName', 'editMode', 'editIsActive', 'editLiveData', 'editSandboxData']);
    }

    public function saveGateway(): void
    {
        $this->validate([
            'editName'     => 'required|string|max:255',
            'editMode'     => 'required|in:live,sandbox',
            'editIsActive' => 'boolean',
        ]);

        $gateway = PaymentGateway::findOrFail($this->gatewayId);

        $gateway->update([
            'name'         => $this->editName,
            'is_active'    => $this->editIsActive,
            'mode'         => $this->editMode,
            'live_data'    => array_filter($this->editLiveData,    fn($v) => $v !== ''),
            'sandbox_data' => array_filter($this->editSandboxData, fn($v) => $v !== ''),
            'updated_by'   => admin()->id,
        ]);

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: "{$gateway->name} gateway updated successfully.");
    }

    #[Computed]
    public function currentGateway(): ?PaymentGateway
    {
        return $this->gatewayId ? PaymentGateway::find($this->gatewayId) : null;
    }

    #[Computed]
    public function currentFields(): array
    {
        $gateway = $this->currentGateway;
        return $gateway ? ($this->credentialFields()[$gateway->slug] ?? []) : [];
    }

    #[Computed]
    public function modeOptions(): array
    {
        return MethodModeStatus::options();
    }

    protected function credentialFields(): array
    {
        return [
            'stripe' => [
                ['key' => 'api_key',        'label' => 'Publishable Key',  'type' => 'text'],
                ['key' => 'secret_key',     'label' => 'Secret Key',       'type' => 'password'],
                ['key' => 'webhook_secret', 'label' => 'Webhook Secret',   'type' => 'password'],
            ],
            'crypto' => [
                ['key' => 'api_key',      'label' => 'API Key',          'type' => 'password'],
                ['key' => 'email',        'label' => 'Account Email',    'type' => 'text'],
                ['key' => 'password',     'label' => 'Password',         'type' => 'password'],
                // ['key' => 'callback_url', 'label' => 'IPN Callback URL', 'type' => 'text'],
                ['key' => 'base_url',     'label' => 'Base URL',         'type' => 'text'],
            ],
            'wallet' => [],
            'tebex' => [
                ['key' => 'project_id',   'label' => 'Project ID',   'type' => 'text'],
                ['key' => 'public_token', 'label' => 'Public Token', 'type' => 'text'],
                ['key' => 'private_key',  'label' => 'Private Key',  'type' => 'password'],
                ['key' => 'checkout_url', 'label' => 'Checkout URL', 'type' => 'text'],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.backend.admin.payment-gateway.edit');
    }
}
