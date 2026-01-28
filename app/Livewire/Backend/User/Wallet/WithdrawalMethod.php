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
use Illuminate\Support\Carbon;
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

    protected array $limitStatuses = ['pending', 'completed'];

    protected array $limitContextCache = [];

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

                $this->validateLimits($method, $amount);

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

            $this->redirect(route('user.wallet.withdrawal-methods'), navigate: true);
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

        $limitContexts = [];
        foreach ($methods as $method) {
            $limitContexts[$method->id] = $this->buildLimitContext($method);
        }

        return view('livewire.backend.user.wallet.withdrawal-method', [
            'methods' => $methods,
            'walletSummary' => $this->walletSummary(),
            'recentWithdrawals' => $this->recentWithdrawals(),
            'limitContexts' => $limitContexts,
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

    protected function buildLimitContext(WithdrawalMethodModel $method): array
    {
        if (isset($this->limitContextCache[$method->id])) {
            return $this->limitContextCache[$method->id];
        }

        $baseQuery = WithdrawalRequest::where('user_id', user()->id)
            ->where('withdrawal_method_id', $method->id)
            ->whereHas('currentStatusHistory', function ($query) {
                $query->whereIn('to_status', $this->limitStatuses);
            });
        $todayQuery = (clone $baseQuery)->whereDate('created_at', Carbon::now()->toDateString());
        $todayAmount = (clone $todayQuery)->sum('amount');
        $todayCount = (clone $todayQuery)->count();

        $weekQuery = (clone $baseQuery)->where('created_at', '>=', Carbon::now()->startOfWeek());
        $weekAmount = (clone $weekQuery)->sum('amount');
        $weekCount = (clone $weekQuery)->count();

        $monthQuery = (clone $baseQuery)->where('created_at', '>=', Carbon::now()->startOfMonth());
        $monthAmount = (clone $monthQuery)->sum('amount');
        $monthCount = (clone $monthQuery)->count();

        $limits = [
            'daily_limit' => $this->normalizeLimit($method->daily_limit),
            'weekly_limit' => $this->normalizeLimit($method->weekly_limit),
            'monthly_limit' => $this->normalizeLimit($method->monthly_limit),
        ];

        $blocked = false;
        $blockedReason = null;

        if (! is_null($limits['daily_limit']) && $todayCount >= $limits['daily_limit']) {
            $blocked = true;
            $blockedReason = __('Daily withdrawal limit reached.');
        } elseif (! is_null($limits['weekly_limit']) && $weekCount >= $limits['weekly_limit']) {
            $blocked = true;
            $blockedReason = __('Weekly withdrawal limit reached.');
        } elseif (! is_null($limits['monthly_limit']) && $monthCount >= $limits['monthly_limit']) {
            $blocked = true;
            $blockedReason = __('Monthly withdrawal limit reached.');
        }

        return $this->limitContextCache[$method->id] = [
            'daily_limit' => $limits['daily_limit'],
            'weekly_limit' => $limits['weekly_limit'],
            'monthly_limit' => $limits['monthly_limit'],
            'daily_count' => (int) $todayCount,
            'weekly_count' => (int) $weekCount,
            'monthly_count' => (int) $monthCount,
            'daily_used' => (float) $todayAmount,
            'weekly_used' => (float) $weekAmount,
            'monthly_used' => (float) $monthAmount,
            'blocked' => $blocked,
            'blocked_reason' => $blockedReason,
        ];
    }

    protected function normalizeLimit($value): ?float
    {
        if (is_null($value)) {
            return null;
        }

        $float = (float) $value;

        return $float > 0 ? $float : null;
    }

    protected function validateLimits(WithdrawalMethodModel $method, float $amount): void
    {
        $context = $this->buildLimitContext($method);
        $errors = [];

        if (! is_null($context['daily_limit'])) {
            $nextCount = $context['daily_count'] + 1;
            if ($nextCount > $context['daily_limit']) {
                $errors[] = __('Daily withdrawal request limit exceeded. Allowed: :limit per day.', [
                    'limit' => $context['daily_limit'],
                ]);
            }
        }

        if (! is_null($context['weekly_limit'])) {
            $nextCount = $context['weekly_count'] + 1;
            if ($nextCount > $context['weekly_limit']) {
                $errors[] = __('Weekly withdrawal request limit exceeded. Allowed: :limit per week.', [
                    'limit' => $context['weekly_limit'],
                ]);
            }
        }

        if (! is_null($context['monthly_limit'])) {
            $nextCount = $context['monthly_count'] + 1;
            if ($nextCount > $context['monthly_limit']) {
                $errors[] = __('Monthly withdrawal request limit exceeded. Allowed: :limit per month.', [
                    'limit' => $context['monthly_limit'],
                ]);
            }
        }

        if (! empty($errors)) {
            throw ValidationException::withMessages([
                'withdrawalAmount' => implode(' ', $errors),
            ]);
        }
    }
}
