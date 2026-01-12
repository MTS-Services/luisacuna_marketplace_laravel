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

        // Initialize dynamic fields
        foreach (json_decode($this->method->required_fields, true) as $fieldName => $fieldRules) {
            $this->account_data[$fieldName] = '';
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
        $this->account_data = [];

        foreach (json_decode($this->method->required_fields, true) as $field) {
            $name = Str::slug($field['name'], '_');
            $this->account_data[$name] = '';
        }

        $this->resetValidation();
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
        return view('livewire.backend.user.wallet.withdrawal-form');
    }
}
