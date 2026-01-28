<?php

namespace App\Livewire\Backend\User\Wallet;

use App\Enums\ActiveInactiveEnum;
use App\Enums\CalculationType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WithdrawalFeeType;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WithdrawalMethod as WithdrawalMethodModel;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalStatusHistory;
use App\Services\CurrencyService;
use App\Services\UserWithdrawalAccountService;
use App\Services\WithdrawalMethodService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class WithdrawalMethod extends Component
{
    use WithNotification;

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
        $this->resetWithdrawalForm();
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

                $currency = $this->currencyService->getCurrentCurrency();

                $wallet = Wallet::where('user_id', user()->id)->where('currency_code', $currency->code)->first();
                $wallet->update([
                    'balance' => $wallet->balance - $finalAmount,
                    'pending_balance' => $wallet->pending_balance + $finalAmount,
                ]);

                // Create withdrawal request with pending status
                $request = WithdrawalRequest::create([
                    'user_id' => user()->id,
                    'withdrawal_method_id' => $method->id,
                    'currency_id' => $this->getCurrencyId(),
                    'amount' => $amount,
                    'fee_amount' => $feeAmount,
                    'tax_amount' => 0,
                    'final_amount' => $finalAmount,
                    'status' => 'pending',
                ]);

                // Create status history entry for pending status
                WithdrawalStatusHistory::create([
                    'withdrawal_request_id' => $request->id,
                    'from_status' => null,
                    'to_status' => 'pending',
                    'changed_by' => null,
                    'notes' => 'Withdrawal request submitted by user',
                    'metadata' => [
                        'requested_amount' => $amount,
                        'fee_amount' => $feeAmount,
                        'final_amount' => $finalAmount,
                        'wallet_balance_before' => $wallet->balance,
                        'pending_balance_before' => $wallet->pending_balance,
                    ],
                ]);

                // Create Transaction record with pending status
                Transaction::create([
                    'user_id' => user()->id,
                    'type' => TransactionType::WITHDRAWAL,
                    'status' => TransactionStatus::PENDING,
                    'calculation_type' => CalculationType::DEBIT,
                    'amount' => $finalAmount,
                    'fee_amount' => $feeAmount,
                    'net_amount' => $amount,
                    'currency' => $currency?->code ?? 'USD',
                    'source_id' => $request->id,
                    'source_type' => WithdrawalRequest::class,
                    'balance_snapshot' => $wallet->balance,
                    'notes' => 'Withdrawal request submitted - pending admin approval',
                    'metadata' => [
                        'requested_amount' => $amount,
                        'fee_amount' => $feeAmount,
                        'final_amount' => $finalAmount,
                        'withdrawal_method' => $method->name,
                        'withdrawal_method_id' => $method->id,
                    ],
                ]);
            });

            $this->toastSuccess('Your withdrawal request has been submitted successfully and is pending approval.');
            $this->closeWithdrawalModal();
            $this->dispatch('withdrawal-submitted');
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $throwable) {
            report($throwable);
            session()->flash('error', 'We could not process your withdrawal request. Please try again later.');
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
        $this->showWithdrawalModal = false;
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
            'walletSummary' => $this->walletSummary(),
            'recentWithdrawals' => $this->recentWithdrawals(),
        ]);
    }

    protected function walletSummary(): object
    {
        $currency = $this->currencyService->getCurrentCurrency();

        $walletQuery = Wallet::where('user_id', user()->id);

        if ($currency?->code) {
            $walletQuery->where('currency_code', $currency->code);
        }

        $wallet = $walletQuery->first();

        return (object) [
            'available' => (float) ($wallet?->balance ?? 0),
            'pending' => (float) ($wallet?->pending_balance ?? 0),
            'total_withdrawn' => (float) ($wallet?->total_withdrawals ?? 0),
        ];
    }

    protected function recentWithdrawals()
    {
        return WithdrawalRequest::with(['withdrawalMethod', 'currentStatusHistory'])
            ->where('user_id', user()->id)
            ->latest()
            ->paginate(10);
    }
}
