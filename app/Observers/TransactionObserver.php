<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        Log::info('Transaction created', [
            'transaction_id' => $transaction->transaction_id,
            'order_id' => $transaction->order_id,
            'type' => $transaction->type->value,
            'amount' => $transaction->amount,
        ]);

        // If transaction is for wallet payment, update wallet statistics
        if (
            $transaction->payment_gateway === 'wallet' &&
            $transaction->status === TransactionStatus::PAID
        ) {
            $this->updateWalletStats($transaction);
        }
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        // Check if status changed to COMPLETED
        if (
            $transaction->wasChanged('status') &&
            $transaction->status === TransactionStatus::PAID
        ) {

            Log::info('Transaction completed', [
                'transaction_id' => $transaction->transaction_id,
                'order_id' => $transaction->order_id,
            ]);

            // Update processed_at if not set
            if (!$transaction->processed_at) {
                $transaction->processed_at = now();
                $transaction->saveQuietly(); // Save without triggering observer again
            }
        }
    }

    /**
     * Update wallet statistics
     */
    protected function updateWalletStats(Transaction $transaction): void
    {
        if ($wallet = $transaction->user->wallet) {
            $wallet->update([
                'last_withdrawal_at' => now(),
            ]);
        }
    }
}
