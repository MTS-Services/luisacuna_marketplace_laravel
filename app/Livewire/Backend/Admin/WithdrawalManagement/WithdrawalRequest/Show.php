<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalRequest;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalStatusHistory;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    use WithNotification;

    public bool $showModal = false;

    public WithdrawalRequest $data;

    public ?string $note = null;

    public function mount(WithdrawalRequest $data): void
    {
        $this->data = $data->load([
            'user',
            'withdrawalMethod',
            'currentStatusHistory',
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.withdrawal-request.show');
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->note = null;
        $this->data->refresh();
    }

    public function accept(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        $this->updateStatus($id, 'completed', null);
    }

    public function reject(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        $this->updateStatus($id, 'rejected', $this->note);
        $this->showModal = false;
        $this->note = null;
    }

    protected function updateStatus(int $id, string $toStatus, ?string $notes): void
    {
        try {
            DB::transaction(function () use ($id, $toStatus, $notes) {
                // Lock withdrawal request for update to prevent race conditions
                $request = WithdrawalRequest::lockForUpdate()
                    ->with('currentStatusHistory')
                    ->find($id);

                if (! $request) {
                    throw new \Exception('Withdrawal request not found.');
                }

                $fromStatus = $request->current_status;

                // Validate current status is pending
                if ($fromStatus !== 'pending') {
                    throw new \Exception('Only pending withdrawal requests can be updated.');
                }

                // Lock wallet for update
                $wallet = Wallet::lockForUpdate()
                    ->where('user_id', $request->user_id)
                    ->first();

                if (! $wallet) {
                    throw new \Exception('User wallet not found.');
                }

                $finalAmount = (float) $request->final_amount;

                // Validate pending balance
                if ((float) $wallet->pending_balance < $finalAmount) {
                    throw new \Exception('Insufficient pending balance for this withdrawal.');
                }

                if ($toStatus === 'completed') {
                    // APPROVE: Deduct from both balance and pending_balance
                    $this->processApproval($request, $wallet, $finalAmount, $fromStatus, $notes);
                } elseif ($toStatus === 'rejected') {
                    // REJECT: Release funds from pending_balance only
                    $this->processRejection($request, $wallet, $finalAmount, $fromStatus, $notes);
                }

                // Refresh the data
                $this->data->refresh();
            });

            $statusLabel = $toStatus === 'completed' ? 'approved' : $toStatus;
            $this->success("Withdrawal request {$statusLabel} successfully.");
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            Log::error('Error updating withdrawal request: '.$exception->getMessage(), [
                'request_id' => $id,
                'to_status' => $toStatus,
                'trace' => $exception->getTraceAsString(),
            ]);
        } catch (\Throwable $throwable) {
            report($throwable);
            $this->error('Failed to update withdrawal request. Please try again.');
            Log::error('Unexpected error updating withdrawal request: '.$throwable->getMessage(), [
                'request_id' => $id,
                'to_status' => $toStatus,
            ]);
        }
    }

    /**
     * Process withdrawal approval (completed status)
     */
    protected function processApproval(
        WithdrawalRequest $request,
        Wallet $wallet,
        float $finalAmount,
        string $fromStatus,
        ?string $notes
    ): void {
        // Update withdrawal request status
        $request->update([
            'status' => 'completed',
            'approved_at' => now(),
            'approved_by' => admin()?->id,
        ]);

        // Create status history for approval
        WithdrawalStatusHistory::create([
            'withdrawal_request_id' => $request->id,
            'from_status' => $fromStatus,
            'to_status' => 'completed',
            'changed_by' => admin()?->id,
            'notes' => $notes ?? 'Withdrawal request approved by admin',
            'metadata' => [
                'final_amount' => $finalAmount,
                'wallet_balance_before' => $wallet->balance,
                'wallet_pending_balance_before' => $wallet->pending_balance,
                'wallet_total_withdrawals_before' => $wallet->total_withdrawals,
                'approved_at' => now()->toDateTimeString(),
                'approved_by' => admin()?->id,
            ],
        ]);

        // Update transaction status to COMPLETED
        $transaction = Transaction::where('source_id', $request->id)
            ->where('source_type', WithdrawalRequest::class)
            ->where('user_id', $request->user_id)
            ->where('status', TransactionStatus::PENDING)
            ->first();

        if ($transaction) {
            $transaction->update([
                'status' => TransactionStatus::PAID,
                'notes' => 'Withdrawal paid - funds transferred',
                'processed_at' => now(),
            ]);
        }

        // Update wallet: Deduct from both balance and pending_balance
        $newBalance = max(0, (float) $wallet->balance - $finalAmount);
        $newPendingBalance = max(0, (float) $wallet->pending_balance - $finalAmount);
        $newTotalWithdrawals = (float) $wallet->total_withdrawals + $finalAmount;

        $wallet->update([
            'balance' => $newBalance,
            'pending_balance' => $newPendingBalance,
            'total_withdrawals' => $newTotalWithdrawals,
            'last_withdrawal_at' => now(),
        ]);

        Log::info('Withdrawal request approved', [
            'request_id' => $request->id,
            'user_id' => $request->user_id,
            'final_amount' => $finalAmount,
            'new_balance' => $newBalance,
            'new_pending_balance' => $newPendingBalance,
            'approved_by' => admin()?->id,
        ]);
    }

    /**
     * Process withdrawal rejection (rejected status)
     */
    protected function processRejection(
        WithdrawalRequest $request,
        Wallet $wallet,
        float $finalAmount,
        string $fromStatus,
        ?string $notes
    ): void {
        // Update withdrawal request status
        $request->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => admin()?->id,
            'rejection_reason' => $notes,
            'note' => $notes, // Keep backward compatibility
        ]);

        // Create status history for rejection
        WithdrawalStatusHistory::create([
            'withdrawal_request_id' => $request->id,
            'from_status' => $fromStatus,
            'to_status' => 'rejected',
            'changed_by' => admin()?->id,
            'notes' => $notes ?? 'Withdrawal request rejected by admin',
            'metadata' => [
                'final_amount' => $finalAmount,
                'wallet_balance_before' => $wallet->balance,
                'wallet_pending_balance_before' => $wallet->pending_balance,
                'rejected_at' => now()->toDateTimeString(),
                'rejected_by' => admin()?->id,
                'rejection_reason' => $notes,
            ],
        ]);

        // Update transaction status to FAILED
        $transaction = Transaction::where('source_id', $request->id)
            ->where('source_type', WithdrawalRequest::class)
            ->where('user_id', $request->user_id)
            ->where('status', TransactionStatus::PENDING)
            ->first();

        if ($transaction) {
            $transaction->update([
                'status' => TransactionStatus::FAILED,
                'notes' => 'Withdrawal rejected - '.($notes ?? 'No reason provided'),
                'failure_reason' => $notes,
                'processed_at' => now(),
            ]);
        }

        // Update wallet: Release funds from pending_balance only (balance stays same)
        $newPendingBalance = max(0, (float) $wallet->pending_balance - $finalAmount);

        $wallet->update([
            'pending_balance' => $newPendingBalance,
        ]);

        Log::info('Withdrawal request rejected', [
            'request_id' => $request->id,
            'user_id' => $request->user_id,
            'final_amount' => $finalAmount,
            'balance' => $wallet->balance, // Balance unchanged
            'new_pending_balance' => $newPendingBalance,
            'rejected_by' => admin()?->id,
            'reason' => $notes,
        ]);
    }
}
