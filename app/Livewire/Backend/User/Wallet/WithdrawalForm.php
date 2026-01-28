<?php

namespace App\Livewire\Backend\User\Wallet;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Services\WithdrawalMethodService;
use App\Services\UserWithdrawalAccountService;
use App\Models\WithdrawalMethod as ModelsWithdrawalMethod;
use App\Traits\Livewire\WithNotification;

class WithdrawalForm extends Component
{
    use WithFileUploads, WithNotification;

    public ModelsWithdrawalMethod $method;

    public $account_name = '';
    public array $account_data = [];

    /** @var array<int, array<string, mixed>> */
    public array $dynamicFields = [];

    protected WithdrawalMethodService $withdrawalMethodService;
    protected UserWithdrawalAccountService $userWithdrawalAccountService;

    public function boot(
        WithdrawalMethodService $withdrawalMethodService,
        UserWithdrawalAccountService $userWithdrawalAccountService
    ) {
        $this->withdrawalMethodService = $withdrawalMethodService;
        $this->userWithdrawalAccountService = $userWithdrawalAccountService;
    }

    public function mount(ModelsWithdrawalMethod $method)
    {
        $this->method = $method;
        $this->dynamicFields = $this->normalizeFields($method->required_fields);

        foreach ($this->dynamicFields as $field) {
            $key = $this->fieldKey($field['name']);
            if (! array_key_exists($key, $this->account_data)) {
                $this->account_data[$key] = '';
            }
        }
    }

    public function save()
    {
        $validated = $this->validate($this->getRules());

        try {
            // Create the withdrawal account
            $validated['user_id'] = user()->id;
            $validated['withdrawal_method_id'] = $this->method->id;
            $account = $this->userWithdrawalAccountService->createAccount($validated);
            if (!$account) {
                $this->error('Failed to create withdrawal account.');
                return;
            }

            $this->toastSuccess('Withdrawal account created successfully.');
            // Reset form
            $this->resetForm();

            // Redirect to withdrawal methods list
            return redirect()->route('user.wallet.withdrawal-methods');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error creating withdrawal account: ' . $e->getMessage());
            $this->error('Failed to create withdrawal account.');
        }
    }

    public function resetForm()
    {
        $this->account_name = '';

        foreach ($this->dynamicFields as $field) {
            $name = $this->fieldKey($field['name']);
            $this->account_data[$name] = '';
        }

        $this->resetValidation();
    }


    public function getRules(): array
    {
        $rules = [
            'account_name' => 'required|string|max:255',
        ];

        foreach ($this->dynamicFields as $field) {
            $name = $this->fieldKey($field['name']);
            $validation = ($field['validation'] ?? 'nullable') === 'optional'
                ? 'nullable'
                : ($field['validation'] ?? 'nullable');

            $rules["account_data.$name"] = $validation;
        }

        return $rules;
    }

    protected function normalizeFields($fields): array
    {
        if (is_string($fields)) {
            $decoded = json_decode($fields, true);
            $fields = is_array($decoded) ? $decoded : [];
        }

        return is_array($fields) ? $fields : [];
    }

    protected function fieldKey(string $name): string
    {
        return Str::slug($name, '_');
    }

    public function render()
    {
        return view('livewire.backend.user.wallet.withdrawal-form', [
            'dynamicFields' => $this->dynamicFields,
        ]);
    }
}
