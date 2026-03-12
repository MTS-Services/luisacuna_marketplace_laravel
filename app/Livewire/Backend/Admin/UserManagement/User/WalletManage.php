<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Enums\CalculationType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletFreezeStatus;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletFreeze;
use App\Services\CurrencyService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class WalletManage extends Component
{
    use WithNotification;
    use WithPagination;

    public User $user;

    public ?Wallet $wallet = null;

    public float $addAmount = 0;

    public string $addReason = '';

    public float $cutAmount = 0;

    public string $cutReason = '';

    public float $frozenAmount = 0;

    public int $perPage = 10;

    protected CurrencyService $currencyService;

    public function boot(CurrencyService $currencyService): void
    {
        $this->currencyService = $currencyService;
    }

    public function mount(User $user): void
    {
        $this->user = $user->load('wallet');
        $this->wallet = $this->user->wallet;
        $this->frozenAmount = $this->calculateFrozenAmount();
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.user.wallet-manage', [
            'transactions' => $this->getTransactions(),
        ]);
    }

    public function addBalance(): void
    {
        $this->validate([
            'addAmount' => ['required', 'numeric', 'gt:0'],
            'addReason' => ['required', 'string', 'max:1000'],
        ]);

        $adminId = auth('admin')->id();

        try {
            $result = $this->performWalletAdjustment(
                amount: (float) $this->addAmount,
                reason: $this->addReason,
                adminId: $adminId,
                isCredit: false,
            );

            if (! $result['success']) {
                $this->error($result['message']);

                return;
            }

            $this->success($result['message']);
            $this->reset(['addAmount', 'addReason']);
        } catch (\Throwable $e) {
            Log::error('Failed to add balance to user wallet', [
                'user_id' => $this->user->id,
                'admin_id' => $adminId,
                'error' => $e->getMessage(),
            ]);

            $this->error(__('Failed to add balance: :message', ['message' => $e->getMessage()]));
        }

        $this->refreshWalletState();
    }

    public function cutBalance(): void
    {
        $this->validate([
            'cutAmount' => ['required', 'numeric', 'gt:0'],
            'cutReason' => ['required', 'string', 'max:1000'],
        ]);

        $adminId = auth('admin')->id();

        try {
            $result = $this->performWalletAdjustment(
                amount: (float) $this->cutAmount,
                reason: $this->cutReason,
                adminId: $adminId,
                isCredit: true,
            );

            if (! $result['success']) {
                $this->error($result['message']);

                return;
            }

            $this->success($result['message']);
            $this->reset(['cutAmount', 'cutReason']);
        } catch (\Throwable $e) {
            Log::error('Failed to deduct balance from user wallet', [
                'user_id' => $this->user->id,
                'admin_id' => $adminId,
                'error' => $e->getMessage(),
            ]);

            $this->error(__('Failed to cut balance: :message', ['message' => $e->getMessage()]));
        }

        $this->refreshWalletState();
    }

    protected function performWalletAdjustment(
        float $amount,
        string $reason,
        ?int $adminId,
        bool $isCredit,
    ): array {
        $defaultCurrency = $this->currencyService->getDefaultCurrency();

        return DB::transaction(function () use ($amount, $reason, $adminId, $isCredit, $defaultCurrency) {
            $wallet = Wallet::where('user_id', $this->user->id)->lockForUpdate()->first();

            if (! $wallet) {
                $wallet = Wallet::create([
                    'user_id' => $this->user->id,
                    'currency_code' => $defaultCurrency->code,
                    'balance' => 0,
                    'locked_balance' => 0,
                    'pending_balance' => 0,
                    'total_deposits' => 0,
                    'total_withdrawals' => 0,
                ]);
            }

            $balanceBefore = (float) $wallet->balance;
            $amountDefault = $amount;

            if ($isCredit && $balanceBefore < $amountDefault) {
                return [
                    'success' => false,
                    'message' => __('Insufficient wallet balance to deduct the requested amount.'),
                ];
            }

            $balanceAfter = $isCredit
                ? $balanceBefore - $amountDefault
                : $balanceBefore + $amountDefault;

            $wallet->balance = $balanceAfter;

            if ($isCredit) {
                $wallet->total_withdrawals = $wallet->total_withdrawals + $amountDefault;
                $wallet->last_withdrawal_at = now();
            } else {
                $wallet->total_deposits = $wallet->total_deposits + $amountDefault;
                $wallet->last_deposit_at = now();
            }

            $wallet->save();

            $transaction = Transaction::create([
                'user_id' => $this->user->id,
                'type' => $isCredit ? TransactionType::WITHDRAWAL->value : TransactionType::TOPUP->value,
                'status' => TransactionStatus::PAID->value,
                'calculation_type' => $isCredit ? CalculationType::CREDIT->value : CalculationType::DEBIT->value,
                'amount' => $amountDefault,
                'currency' => $wallet->currency_code ?? $defaultCurrency->code,
                'payment_gateway' => 'admin-adjustment',
                'balance_snapshot' => $balanceAfter,
                'metadata' => [
                    'source' => 'admin-adjustment',
                    'admin_id' => $adminId,
                    'admin_reason' => $reason,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                ],
                'notes' => $isCredit
                    ? "Admin manual deduction: -{$amountDefault} {$wallet->currency_code}"
                    : "Admin manual top-up: +{$amountDefault} {$wallet->currency_code}",
                'processed_at' => now(),
            ]);

            Log::info('Admin wallet adjustment recorded', [
                'user_id' => $this->user->id,
                'admin_id' => $adminId,
                'amount' => $amountDefault,
                'is_credit' => $isCredit,
                'transaction_id' => $transaction->transaction_id,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
            ]);

            $actionLabel = $isCredit ? __('deducted from') : __('added to');

            return [
                'success' => true,
                'message' => __(':amount :currency has been :action the user wallet.', [
                    'amount' => number_format($amountDefault, 2),
                    'currency' => $wallet->currency_code ?? $defaultCurrency->code,
                    'action' => $actionLabel,
                ]),
            ];
        });
    }

    protected function refreshWalletState(): void
    {
        $this->user->load('wallet');
        $this->wallet = $this->user->wallet;
        $this->frozenAmount = $this->calculateFrozenAmount();
        $this->resetPage();
    }

    protected function calculateFrozenAmount(): float
    {
        return (float) WalletFreeze::where('user_id', $this->user->id)
            ->where('status', WalletFreezeStatus::FROZEN)
            ->sum('amount');
    }

    protected function getTransactions(): LengthAwarePaginator
    {
        return Transaction::query()
            ->forUser($this->user->id)
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }
}
