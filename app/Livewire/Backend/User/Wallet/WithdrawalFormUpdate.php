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

        $fields = json_decode($this->method->required_fields, true);

        foreach ($fields as $field) {
            $name = Str::slug($field['name'], '_');
            $this->account_data[$name] = $this->account->account_data[$name] ?? '';
        }
    }

    public function update()
    {
        // dd($this->account->id);

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

        foreach (json_decode($this->method->required_fields, true) as $field) {
            $name = Str::slug($field['name'], '_');
            $validation = $field['validation'] === 'optional' ? 'nullable' : $field['validation'];
            $rules["account_data.$name"] = $validation;
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.backend.user.wallet.withdrawal-form-update');
    }
}
