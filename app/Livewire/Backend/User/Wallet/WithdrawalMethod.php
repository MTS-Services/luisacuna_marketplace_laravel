<?php

namespace App\Livewire\Backend\User\Wallet;

use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
use App\Models\WithdrawalMethod as WithdrawalMethodModel;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalStatusHistory;
use App\Services\CurrencyService;
use App\Services\UserWithdrawalAccountService;
use App\Services\WithdrawalMethodService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class WithdrawalMethod extends Component
{
    protected WithdrawalMethodService $withdrawalMethodService;

    protected UserWithdrawalAccountService $accountService;

    protected CurrencyService $currencyService;

    public bool $showModal = false;

    public bool $isLoading = false;

    public $selectedMethod = null;

    public $accountData = null;

    public bool $showWithdrawalModal = false;

    public ?int $selectedMethodId = null;

    public ?string $withdrawalAmount = null;

    public ?string $withdrawalNote = null;

    public bool $methodLocked = false;

    public ?string $selectedMethodName = null;

    public function boot(
        WithdrawalMethodService $withdrawalMethodService,
        UserWithdrawalAccountService $accountService,
        CurrencyService $currencyService
    ) {
        $this->withdrawalMethodService = $withdrawalMethodService;
        $this->accountService = $accountService;
        $this->currencyService = $currencyService;
    }

    public function openModal($accountId)
    {
        $this->showModal = true;
        $this->isLoading = true;
        $this->selectedMethod = null;

        // Fetch data
        $this->accountData = $this->accountService->findData($accountId);

        $this->isLoading = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMethod = null;
        $this->isLoading = false;
    }

    public function openWithdrawalModal(?int $methodId = null): void
    {
        $this->resetWithdrawalForm();
        $this->selectedMethodId = $methodId;
        $this->methodLocked = filled($methodId);
        $this->selectedMethodName = $this->resolveMethodName($methodId);
        $this->showWithdrawalModal = true;
    }

    public function closeWithdrawalModal(): void
    {
        $this->showWithdrawalModal = false;
        $this->methodLocked = false;
    }

    public function submitWithdrawalRequest(): void
    {
        $method = $this->resolveWithdrawalMethod();
        if (! $method) {
            $this->addError('selectedMethodId', 'The selected withdrawal method is unavailable.');

            return;
        }

        $rules = [
            'withdrawalAmount' => array_merge(['required', 'numeric'], $this->amountRules($method)),
        ];

        $this->validate($rules);

        try {
            DB::transaction(function () use ($method) {
                $amount = round((float) $this->withdrawalAmount, 2);
                $feeAmount = $this->calculateFee($method, $amount);
                $finalAmount = round($amount + $feeAmount, 2);

                $request = WithdrawalRequest::create([
                    'user_id' => user()->id,
                    'withdrawal_method_id' => $method->id,
                    'currency_id' => $this->getCurrencyId(),
                    'amount' => $amount,
                    'fee_amount' => $feeAmount,
                    'tax_amount' => 0,
                    'final_amount' => $finalAmount,
                ]);

                WithdrawalStatusHistory::create([
                    'withdrawal_request_id' => $request->id,
                    'from_status' => null,
                    'to_status' => 'pending',
                    'changed_by' => null,
                    'notes' => null,
                    'metadata' => null,
                ]);
            });

            session()->flash('success', 'Your withdrawal request has been submitted.');
            $this->closeWithdrawalModal();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $throwable) {
            report($throwable);
            session()->flash('error', 'We could not process your withdrawal request. Please try again.');
        }
    }

    protected function resetWithdrawalForm(): void
    {
        $this->resetValidation();
        $this->selectedMethodId = null;
        $this->withdrawalAmount = null;
        $this->withdrawalNote = null;
        $this->methodLocked = false;
        $this->selectedMethodName = null;
    }

    protected function resolveWithdrawalMethod(): ?WithdrawalMethodModel
    {
        if (! $this->selectedMethodId) {
            return null;
        }

        $method = $this->withdrawalMethodService->findData($this->selectedMethodId);

        if (! $method || $method->status?->value !== ActiveInactiveEnum::ACTIVE->value) {
            return null;
        }

        return $method;
    }

    protected function resolveMethodName(?int $methodId): ?string
    {
        if (! $methodId) {
            return null;
        }

        return optional($this->withdrawalMethodService->findData($methodId))->name;
    }

    protected function amountRules(WithdrawalMethodModel $method): array
    {
        $rules = [];

        if (! is_null($method->min_amount)) {
            $rules[] = 'min:'.(float) $method->min_amount;
        }

        if (! is_null($method->max_amount) && (float) $method->max_amount > 0) {
            $rules[] = 'max:'.(float) $method->max_amount;
        }

        return $rules;
    }

    protected function calculateFee(WithdrawalMethodModel $method, float $amount): float
    {
        if ($method->fee_type === WithdrawalFeeType::PERCENTAGE) {
            $percentage = (float) ($method->fee_percentage ?? 0);

            return round(($amount * $percentage) / 100, 2);
        }

        return round((float) ($method->fee_amount ?? 0), 2);
    }

    protected function getCurrencyId(): int
    {
        $currency = $this->currencyService->getCurrentCurrency();

        if (! $currency) {
            throw ValidationException::withMessages([
                'selectedMethodId' => 'Unable to determine currency for this withdrawal.',
            ]);
        }

        return (int) $currency->id;
    }

    public function render()
    {
        $methods = $this->withdrawalMethodService->getAllDatas(
            'created_at',
            'desc',
            ['userWithdrawalAccounts' => function ($query) {
                $query->where('user_id', user()->id);
            }]
        )->where('status', ActiveInactiveEnum::ACTIVE->value);

        return view('livewire.backend.user.wallet.withdrawal-method', [
            'methods' => $methods,
        ]);
    }
}
