<?php

namespace App\Livewire\Backend\User\Wallet;

use App\Models\UserWithdrawalAccount;
use App\Models\WithdrawalMethod as ModelsWithdrawalMethod;
use App\Services\UserWithdrawalAccountService;
use App\Services\WithdrawalMethodService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class WithdrawalFormUpdate extends Component
{
    use WithFileUploads, WithNotification;

    public ModelsWithdrawalMethod $method;

    public UserWithdrawalAccount $account;

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

    public function mount(ModelsWithdrawalMethod $method, UserWithdrawalAccount $account)
    {
        $this->method = $method->load('userWithdrawalAccounts');
        $this->account = $account;
        $this->account_name = $this->account->account_name ?? '';

        $this->dynamicFields = $this->normalizeFields($this->method->required_fields);

        foreach ($this->dynamicFields as $field) {
            $key = $this->fieldKey($field['name']);
            $this->account_data[$key] = $this->account->account_data[$key] ?? '';
        }
    }

    public function update()
    {
        $validated = $this->validate($this->getRules());

        try {
            $validated['account_name'] = $this->account_name;

            $account = $this->userWithdrawalAccountService->updateAccount($this->account->id, user()->id, $validated);

            if (! $account) {
                $this->error('Failed to update withdrawal account.');

                return;
            }

            $this->toastSuccess('Withdrawal account updated successfully.');

            return redirect()->route('user.wallet.withdrawal-methods');
        } catch (\Exception $e) {
            Log::error('Error updating withdrawal account: '.$e->getMessage());
            $this->error('Failed to update withdrawal account.');
        }
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

    public function resetForm(): void
    {
        $this->account_name = $this->account->account_name ?? '';

        foreach ($this->dynamicFields as $field) {
            $key = $this->fieldKey($field['name']);
            $this->account_data[$key] = $this->account->account_data[$key] ?? '';
        }

        $this->resetValidation();
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
        return view('livewire.backend.user.wallet.withdrawal-form-update', [
            'dynamicFields' => $this->dynamicFields,
        ]);
    }
}
