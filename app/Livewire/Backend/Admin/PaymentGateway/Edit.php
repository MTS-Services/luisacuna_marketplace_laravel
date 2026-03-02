<?php

namespace App\Livewire\Backend\Admin\PaymentGateway;

use App\Enums\MethodModeStatus;
use App\Models\PaymentGateway;
use App\Traits\FileManagementTrait;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use FileManagementTrait;
    use WithFileUploads;

    public ?int $gatewayId = null;

    public string $editName = '';

    public string $editMode = 'sandbox';

    public bool $editIsActive = true;

    /** @var \Illuminate\Http\UploadedFile|null */
    public $editIcon = null;

    public bool $editRemoveIcon = false;

    /** @var array<string, string> */
    public array $editLiveData = [];

    /** @var array<string, string> */
    public array $editSandboxData = [];

    public function mount(?int $gatewayId = null): void
    {
        if ($gatewayId !== null) {
            $this->openEdit($gatewayId);
        }
    }

    public function openEdit(int $id): void
    {
        $gateway = PaymentGateway::findOrFail($id);

        $this->gatewayId = $gateway->id;
        $this->editName = $gateway->name;
        $this->editMode = $gateway->mode?->value ?? 'sandbox';
        $this->editIsActive = $gateway->is_active;

        $fields = $this->credentialFields()[$gateway->slug] ?? [];
        $liveData = $gateway->live_data ?? [];
        $sandboxData = $gateway->sandbox_data ?? [];

        $this->editLiveData = [];
        $this->editSandboxData = [];

        foreach ($fields as $field) {
            $this->editLiveData[$field['key']] = $liveData[$field['key']] ?? '';
            $this->editSandboxData[$field['key']] = $sandboxData[$field['key']] ?? '';
        }

        $this->editRemoveIcon = false;
    }

    public function saveGateway(): mixed
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editMode' => 'required|in:live,sandbox',
            'editIsActive' => 'boolean',
            'editIcon' => 'nullable|image|max:2048',
            'editRemoveIcon' => 'nullable|boolean',
        ]);

        $gateway = PaymentGateway::findOrFail($this->gatewayId);

        $iconPath = $this->handleSingleFileUpload(
            newFile: $this->editIcon,
            oldPath: $gateway->icon,
            removeKey: $this->editRemoveIcon,
            folderName: 'payment-gateway-icons'
        );

        $gateway->update([
            'name' => $this->editName,
            'icon' => $iconPath,
            'is_active' => $this->editIsActive,
            'mode' => $this->editMode,
            'live_data' => array_filter($this->editLiveData, fn ($v) => $v !== ''),
            'sandbox_data' => array_filter($this->editSandboxData, fn ($v) => $v !== ''),
            'updated_by' => admin()->id,
        ]);

        $this->dispatch('notify', type: 'success', message: __(':name gateway updated successfully.', ['name' => $gateway->name]));

        return $this->redirect(route('admin.gi.pay-g.index'), navigate: true);
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
