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

class EscrowService
{
    /**
     * Release full escrow funds to the seller's wallet from the freeze record.
     * Used when buyer confirms delivery or 72h auto-completion.
     */
    public function releaseFundsToSeller(Order $order): void
    {
        $order->loadMissing(['source.user']);
        $seller = $order->source?->user;

        if (! $seller) {
            Log::error('EscrowService: Seller not found for fund release', ['order_id' => $order->order_id]);

            return;
        }

        $amount = (float) ($order->getDefaultGrandTotal() - $order->getDefaultTaxAmount());

        if ($amount <= 0) {
            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $seller->id],
            ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
        );

        $freezeWallet = WalletFreeze::query()->where('user_id', $seller->id)->where('order_id', $order->id)->where('status', WalletFreezeStatus::FROZEN)->first();

        $feeAmount = $this->calculatePlatformFee($order);
        $netAmount = $amount - $feeAmount;

        DB::transaction(function () use ($wallet, $order, $seller, $amount, $feeAmount, $netAmount, $freezeWallet) {
            $wallet->lockForUpdate();
            $wallet->increment('balance', $netAmount);

            if ($freezeWallet !== null) {
                $freezeWallet->lockForUpdate();
                $freezeWallet->update([
                    'status' => WalletFreezeStatus::RELEASED,
                    'released_at' => now(),
                ]);
            }

            $newBalance = (float) $wallet->fresh()->balance;

            Transaction::query()->create([
                'user_id' => $seller->id,
                'type' => TransactionType::SALES,
                'status' => TransactionStatus::PAID,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'currency' => $order->default_currency ?? 'USD',
                'balance_snapshot' => $newBalance,
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
        $buyer = $order->user;

        if (! $buyer) {
            Log::error('EscrowService: Buyer not found for refund', ['order_id' => $order->order_id]);

            return;
        }

        $amount = (float) ($order->getDefaultGrandTotal() - $order->getDefaultTaxAmount());

        if ($amount <= 0) {
            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $buyer->id],
            ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
        );

        $freezeWallet = WalletFreeze::query()->where('user_id', $buyer->id)->where('order_id', $order->id)->where('status', WalletFreezeStatus::FROZEN)->first();

        DB::transaction(function () use ($wallet, $order, $buyer, $amount, $freezeWallet) {
            $wallet->lockForUpdate();
            $wallet->increment('balance', $amount);

            $newBalance = (float) $wallet->fresh()->balance;

            if ($freezeWallet !== null) {
                $freezeWallet->lockForUpdate();
                $freezeWallet->update([
                    'status' => WalletFreezeStatus::REFUNDED,
                    'refunded_at' => now(),
                ]);
            }

            Transaction::query()->create([
                'user_id' => $buyer->id,
                'type' => TransactionType::REFUND,
                'status' => TransactionStatus::PAID,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $amount,
                'fee_amount' => 0,
                'net_amount' => $amount,
                'currency' => $order->default_currency ?? 'USD',
                'balance_snapshot' => $newBalance,
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
                    'notes' => "Partial split payment (buyer portion) for order #{$order->order_id}",
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

            $freezeWallet = WalletFreeze::query()->where('user_id', $seller->id)->where('order_id', $order->id)->where('status', WalletFreezeStatus::FROZEN)->first();
            if ($freezeWallet !== null) {
                $freezeWallet->lockForUpdate();
                $freezeWallet->update([
                    'status' => WalletFreezeStatus::SPLIT,
                    'split_at' => now(),
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
            ResolutionType::SellerWins => $this->releaseFundsToSeller($order),
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
            return WalletFreeze::firstOrCreate(
                [
                    'order_id' => $order->id,
                    'user_id' => $seller->id,
                    'wallet_id' => $seller->wallet->id,
                    'status' => WalletFreezeStatus::FROZEN,
                    'amount' => ($order->getDefaultGrandTotal() - $order->getDefaultTaxAmount()),
                    'currency_code' => $order->default_currency ?? 'USD',
                ],
                [
                    'reason' => "Freeze funds for order #{$order->order_id}",
                    'frozen_at' => now(),
                ]
            );
        });
    }
}
