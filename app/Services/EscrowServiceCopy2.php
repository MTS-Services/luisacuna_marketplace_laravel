<?php

namespace App\Services;

use App\Enums\CalculationType;
use App\Enums\ResolutionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletFreezeStatus;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletFreeze;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EscrowServiceCopy2
{
    /**
     * Release full escrow funds to the seller's wallet from the freeze record.
     * Used when buyer confirms delivery or 72h auto-completion.
     */
    public function releaseFundsToSeller(Order $order): void
    {
        Log::info('EscrowService: Releasing funds to seller', ['order_id' => $order->order_id]);
        $order->loadMissing(['source.user']);
        $seller = $order->source?->user;

        if (! $seller) {
            Log::error('EscrowService: Seller not found for fund release', ['order_id' => $order->order_id]);

            return;
        }

        $freezeWallet = WalletFreeze::query()->where('user_id', $seller->id)->where('order_id', $order->id)->where('status', WalletFreezeStatus::FROZEN)->first();
        if (! $freezeWallet) {
            Log::error('EscrowService: Freeze wallet not found for fund release', ['order_id' => $order->order_id]);

            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $seller->id],
            ['currency_code' => $freezeWallet->currency_code, 'balance' => 0],
        );

        DB::transaction(function () use ($freezeWallet, $order, $seller, $wallet) {
            $freezeWallet->lockForUpdate();
            $freezeWallet->update([
                'status' => WalletFreezeStatus::RELEASED,
                'released_at' => now(),
            ]);

            $wallet->lockForUpdate();
            $beforeBalance = $wallet->balance;
            $wallet->increment('balance', $freezeWallet->amount);
            $afterBalance = $wallet->fresh()->balance;

            Transaction::query()->create([
                'user_id' => $seller->id,
                'type' => TransactionType::SALES,
                'status' => TransactionStatus::PAID,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $freezeWallet->amount,
                'fee_amount' => 0,
                'net_amount' => $freezeWallet->amount,
                'currency' => $freezeWallet->currency_code,
                'balance_snapshot' => $beforeBalance,
                'order_id' => $order->id,
                'notes' => "Payment released for order #{$order->order_id}",
                'processed_at' => now(),
            ]);
        });
    }

    /**
     * Refund full escrow to the buyer's wallet from the freeze record.
     * Used when order is cancelled or buyer wins dispute.
     */
    public function refundBuyer(Order $order): void
    {
        $order->loadMissing(['user', 'source.user']);
        $buyer = $order->user;
        $seller = $order->source?->user;

        if (! $buyer || ! $seller) {
            Log::error('EscrowService: Buyer or seller not found for refund', ['order_id' => $order->order_id]);

            return;
        }

        $freezeWallet = WalletFreeze::query()->where('user_id', $seller->id)->where('order_id', $order->id)->where('status', WalletFreezeStatus::FROZEN)->first();
        if (! $freezeWallet) {
            Log::error('EscrowService: Freeze wallet not found for refund', ['order_id' => $order->order_id]);

            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $buyer->id],
            ['currency_code' => $freezeWallet->currency_code, 'balance' => 0],
        );

        DB::transaction(function () use ($buyer, $order, $freezeWallet, $wallet) {

            $freezeWallet->lockForUpdate();
            $freezeWallet->update([
                'status' => WalletFreezeStatus::REFUNDED,
                'refunded_at' => now(),
            ]);

            $wallet->lockForUpdate();
            $beforeBalance = $wallet->balance;
            $wallet->increment('balance', $freezeWallet->amount);
            $afterBalance = $wallet->fresh()->balance;

            Transaction::query()->create([
                'user_id' => $buyer->id,
                'type' => TransactionType::REFUND,
                'status' => TransactionStatus::PAID,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $freezeWallet->amount,
                'fee_amount' => 0,
                'net_amount' => $freezeWallet->amount,
                'currency' => $freezeWallet->currency_code,
                'balance_snapshot' => $beforeBalance,
                'order_id' => $order->id,
                'notes' => "Payment refunded for order #{$order->order_id}",
                'processed_at' => now(),
            ]);
        });
    }

    /**
     * Apply a partial split: divide the escrow between buyer and seller mathematically.
     */
    public function applyPartialSplit(Order $order, float $buyerAmount, float $sellerAmount): void
    {
        $order->loadMissing(['user', 'source.user']);
        $buyer = $order->user;
        $seller = $order->source?->user;

        if (! $buyer || ! $seller) {
            Log::error('EscrowService: Buyer or seller not found for partial split', ['order_id' => $order->order_id]);

            return;
        }

        DB::transaction(function () use ($order, $buyer, $seller, $buyerAmount, $sellerAmount) {
            if ($buyerAmount > 0) {
                $buyerWallet = Wallet::query()->firstOrCreate(
                    ['user_id' => $buyer->id],
                    ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
                );
                $buyerWallet->lockForUpdate();
                $buyerWallet->increment('balance', $buyerAmount);

                $newBuyerBalance = (float) $buyerWallet->fresh()->balance;

                Transaction::query()->create([
                    'user_id' => $buyer->id,
                    'type' => TransactionType::REFUND,
                    'status' => TransactionStatus::PAID,
                    'calculation_type' => CalculationType::DEBIT,
                    'amount' => $buyerAmount,
                    'fee_amount' => 0,
                    'net_amount' => $buyerAmount,
                    'currency' => $order->default_currency ?? 'USD',
                    'balance_snapshot' => $newBuyerBalance,
                    'order_id' => $order->id,
                    'notes' => "Partial split refund (buyer portion) for order #{$order->order_id}",
                    'processed_at' => now(),
                ]);
            }

            if ($sellerAmount > 0) {
                $sellerWallet = Wallet::query()->firstOrCreate(
                    ['user_id' => $seller->id],
                    ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
                );
                $sellerWallet->lockForUpdate();
                $sellerWallet->increment('balance', $sellerAmount);

                $newSellerBalance = (float) $sellerWallet->fresh()->balance;

                Transaction::query()->create([
                    'user_id' => $seller->id,
                    'type' => TransactionType::SALES,
                    'status' => TransactionStatus::PAID,
                    'calculation_type' => CalculationType::DEBIT,
                    'amount' => $sellerAmount,
                    'fee_amount' => 0,
                    'net_amount' => $sellerAmount,
                    'currency' => $order->default_currency ?? 'USD',
                    'balance_snapshot' => $newSellerBalance,
                    'order_id' => $order->id,
                    'notes' => "Partial split payment (seller portion) for order #{$order->order_id}",
                    'processed_at' => now(),
                ]);
            }
        });
    }

    /**
     * Apply resolution based on the ResolutionType enum.
     */
    public function applyResolution(Order $order, ResolutionType $resolution): void
    {
        match ($resolution) {
            ResolutionType::BuyerWins => $this->refundBuyer($order),
            // ResolutionType::SellerWins => $this->releaseFundsWithHold($order),
            ResolutionType::PartialSplit => $this->applyPartialSplit(
                $order,
                (float) $order->resolution_buyer_amount,
                (float) $order->resolution_seller_amount,
            ),
            ResolutionType::NeutralCancel => $this->refundBuyer($order),
        };
    }

    /**
     * Calculate platform fee for seller payouts.
     */
    protected function calculatePlatformFee(Order $order): float
    {
        $salesTransaction = Transaction::query()
            ->where('order_id', $order->id)
            ->where('type', TransactionType::SALES)
            ->where('status', TransactionStatus::PAID)
            ->first();

        if ($salesTransaction) {
            return (float) $salesTransaction->fee_amount;
        }

        $purchaseTransaction = Transaction::query()
            ->where('order_id', $order->id)
            ->where('type', TransactionType::PURCHSED)
            ->where('status', TransactionStatus::PAID)
            ->first();

        if ($purchaseTransaction) {
            return (float) $purchaseTransaction->fee_amount;
        }

        return 0;
    }

    public function freezeFunds(Order $order): ?WalletFreeze
    {
        $order->loadMissing(['source.user']);
        $seller = $order->source?->user;

        if (! $seller) {
            Log::error('EscrowService: Seller not found for freeze funds', ['order_id' => $order->order_id]);

            return null;
        }

        return DB::transaction(function () use ($order, $seller) {
            return WalletFreeze::create([
                'order_id' => $order->id,
                'user_id' => $seller->id,
                'wallet_id' => $seller->wallet->id,
                'amount' => $order->getDefaultGrandTotal(),
                'currency_code' => $order->default_currency ?? 'USD',
                'status' => WalletFreezeStatus::FROZEN,
                'reason' => "Freeze funds for order #{$order->order_id}",
                'frozen_at' => now(),
            ]);
        });
    }
}
