<?php

namespace App\Listeners;

use App\Events\PaymentSuccessEvent;
use App\Services\NotificationService;
use App\Enums\CustomNotificationType;
use App\Models\Admin;
use App\Models\User;
use App\Jobs\Payment\SendPaymentSuccessEmailJob;
use App\Jobs\Payment\SendPaymentReceivedEmailJob;
use App\Jobs\Payment\SendAdminPaymentEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Exception;

class SendPaymentNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;
    public $timeout = 120;
    public $backoff = [10, 30, 60];

    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function handle(PaymentSuccessEvent $event): void
    {
        try {
            // Fetch fresh data from database
            $order = $event->getOrder();
            $payment = $event->getPayment();

            Log::info('Processing payment notifications', [
                'order_id' => $order->order_id,
                'payment_id' => $payment->payment_id,
            ]);

            // 1. Notify Buyer (Order User)
            $this->notifyBuyer($order, $payment);

            // 2. Notify Seller (Source Owner)
            $this->notifySeller($order, $payment);

            // 3. Notify All Administrators
            $this->notifyAdministrators($order, $payment);

            Log::info('Payment notifications sent successfully', [
                'order_id' => $order->order_id,
                'payment_id' => $payment->payment_id,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send payment notifications', [
                'order_id' => $event->orderId ?? null,
                'payment_id' => $event->paymentId ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Only re-throw if we haven't exceeded max attempts
            if ($this->attempts() < $this->tries) {
                throw $e;
            }
        }
    }

    protected function notifyBuyer($order, $payment): void
    {
        try {
            $buyer = $order->user;

            if (!$buyer) {
                Log::warning('Buyer not found for order', ['order_id' => $order->order_id]);
                return;
            }

            // Create in-app notification
            $this->notificationService->create([
                'type' => CustomNotificationType::USER,
                'sender_id' => null,
                'sender_type' => null,
                'receiver_id' => $buyer->id,
                'receiver_type' => User::class,
                'is_announced' => false,
                'action' => route('user.order.detail', $order->order_id),
                'title' => 'Payment Successful',
                'message' => "Your payment has been processed successfully. Payment of {$payment->currency} " . number_format($payment->amount, 2) . " for Order #{$order->order_id} via {$payment->payment_gateway}.",
                'icon' => 'check-circle',
                'additional' => [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'payment_method' => $payment->payment_gateway,
                ],
            ]);

            // ✅ Dispatch email job instead of sending directly
            SendPaymentSuccessEmailJob::dispatch(
                $order->id,
                $payment->id,
                $buyer->email
            );

            Log::info('Buyer notified (in-app + email queued)', [
                'buyer_id' => $buyer->id,
                'buyer_email' => $buyer->email,
                'order_id' => $order->order_id,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to notify buyer', [
                'buyer_id' => $buyer->id ?? null,
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
            // Don't re-throw - allow other notifications to proceed
        }
    }

    protected function notifySeller($order, $payment): void
    {
        try {
            $seller = $order->source?->user;

            if (!$seller) {
                Log::warning('Seller not found for order', ['order_id' => $order->order_id]);
                return;
            }

            // Don't notify if buyer and seller are the same person
            if ($seller->id === $order->user_id) {
                Log::info('Skipping seller notification (same as buyer)', [
                    'user_id' => $seller->id,
                    'order_id' => $order->order_id,
                ]);
                return;
            }

            // Create in-app notification
            $this->notificationService->create([
                'type' => CustomNotificationType::USER,
                'sender_id' => $order->user_id,
                'sender_type' => User::class,
                'receiver_id' => $seller->id,
                'receiver_type' => User::class,
                'is_announced' => false,
                'action' => route('user.order.detail', $order->order_id),
                'title' => 'Payment Received',
                'message' => "You have received a payment! Payment of {$payment->currency} " . number_format($payment->amount, 2) . " received for Order #{$order->order_id}. Buyer: {$order->user->name}",
                'icon' => 'dollar-sign',
                'additional' => [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'buyer_name' => $order->user->name,
                    'payment_method' => $payment->payment_gateway,
                ],
            ]);

            // ✅ Dispatch email job instead of sending directly
            SendPaymentReceivedEmailJob::dispatch(
                $order->id,
                $payment->id,
                $seller->email
            );

            Log::info('Seller notified (in-app + email queued)', [
                'seller_id' => $seller->id,
                'seller_email' => $seller->email,
                'order_id' => $order->order_id,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to notify seller', [
                'seller_id' => $seller->id ?? null,
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
            // Don't re-throw - allow other notifications to proceed
        }
    }

    protected function notifyAdministrators($order, $payment): void
    {
        try {
            $admins = Admin::where('role_id', 1)->get();

            if ($admins->isEmpty()) {
                Log::warning('No super administrators found', ['order_id' => $order->order_id]);
                return;
            }

            // Create broadcast in-app notification for all admins
            $this->notificationService->create([
                'type' => CustomNotificationType::ADMIN,
                'sender_id' => $order->user_id,
                'sender_type' => User::class,
                'receiver_id' => null,
                'receiver_type' => null,
                'is_announced' => false,
                'action' => route('admin.orders.show', $order->order_id),
                'title' => 'New Payment Received',
                'message' => "A payment has been successfully processed. Payment of {$payment->currency} " . number_format($payment->amount, 2) . " for Order #{$order->order_id} via {$payment->payment_gateway}. Buyer: {$order->user->name}",
                'icon' => 'credit-card',
                'additional' => [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'buyer_name' => $order->user->name,
                    'buyer_email' => $order->user->email,
                    'payment_method' => $payment->payment_gateway,
                ],
            ]);

            // ✅ Dispatch email jobs instead of sending directly
            foreach ($admins as $admin) {
                SendAdminPaymentEmailJob::dispatch(
                    $order->id,
                    $payment->id,
                    $admin->email
                );
            }

            Log::info('Administrators notified (in-app + emails queued)', [
                'admin_count' => $admins->count(),
                'order_id' => $order->order_id,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to notify administrators', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
            // Don't re-throw - this shouldn't block buyer/seller notifications
        }
    }

    public function failed(PaymentSuccessEvent $event, Exception $exception): void
    {
        Log::error('SendPaymentNotifications job failed permanently', [
            'order_id' => $event->orderId ?? null,
            'payment_id' => $event->paymentId ?? null,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts(),
        ]);
    }
}
