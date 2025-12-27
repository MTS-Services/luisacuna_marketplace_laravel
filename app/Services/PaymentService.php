<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentService
{
    public function processPayment(Order $order, string $gateway, array $paymentData = []): array
    {
        try {
            if (!$this->canProcessPayment($order)) {
                return [
                    'success' => false,
                    'message' => 'Order cannot accept payment at this time.',
                    'reason' => 'invalid_order_status',
                ];
            }

            $paymentGateway = \App\Models\PaymentGateway::where('slug', $gateway)
                ->where('is_active', true)
                ->first();

            if (!$paymentGateway || !$paymentGateway->isSupported()) {
                return [
                    'success' => false,
                    'message' => 'Payment gateway not available.',
                    'reason' => 'gateway_unavailable',
                ];
            }

            $paymentMethod = $paymentGateway->paymentMethod();
            return $paymentMethod->startPayment($order, $paymentData);
        } catch (Exception $e) {
            Log::error('Payment processing failed', [
                'order_id' => $order->order_id,
                'gateway' => $gateway,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage(),
                'reason' => 'exception',
            ];
        }
    }


    protected function canProcessPayment(Order $order): bool
    {
        if (!in_array($order->status, [
            OrderStatus::INITIALIZED,
            OrderStatus::PENDING,
            OrderStatus::PARTIALLY_PAID
        ])) {
            Log::warning('Order cannot accept payment', [
                'order_id' => $order->order_id,
                'status' => $order->status->value,
            ]);
            return false;
        }

        if ($order->isFullyPaid()) {
            Log::warning('Order already fully paid', [
                'order_id' => $order->order_id,
            ]);
            return false;
        }

        return true;
    }
}
