<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Services\ConversationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PaymentControllerCopy extends Controller
{
    public function __construct(protected ConversationService $conversationService) {}

    /**
     * Payment success page
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $sessionId = $request->query('session_id');

        // If coming from Stripe, confirm the payment
        if ($sessionId) {
            $gateway = PaymentGateway::where('slug', 'stripe')->first();
            if ($gateway) {
                try {
                    $paymentMethod = $gateway->paymentMethod();
                    $result = $paymentMethod->confirmPayment($sessionId);

                    if (!$result['success']) {
                        Log::warning('Payment confirmation failed on success page', [
                            'session_id' => $sessionId,
                            'order_id' => $orderId,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error confirming payment on success page', [
                        'session_id' => $sessionId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        $order = Order::where('order_id', $orderId)
            ->with(['latestPayment', 'source', 'user'])
            ->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        // Security: Verify order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return redirect()->route('user.order.complete', ['orderId' => $orderId]);
    }

    /**
     * Payment failed page
     */
    public function paymentFailed(Request $request)
    {
        $orderId = $request->query('order_id');

        $order = Order::where('order_id', $orderId)
            ->with(['latestPayment', 'source'])
            ->first();

        // Security: Verify order belongs to authenticated user if order exists
        if ($order && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('payment.failed', compact('order'));
    }

    /**
     * Handle Stripe webhook notifications
     */
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            // Verify webhook signature
            if ($webhookSecret) {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $sigHeader,
                    $webhookSecret
                );
            } else {
                // For development without webhook secret
                $event = json_decode($payload, true);
            }

            Log::info('Stripe webhook received', [
                'event_type' => $event['type'] ?? 'unknown',
                'event_id' => $event['id'] ?? null,
            ]);

            $gateway = PaymentGateway::where('slug', 'stripe')->first();

            if ($gateway) {
                $paymentMethod = $gateway->paymentMethod();
                $paymentMethod->handleWebhook(is_array($event) ? $event : $event->toArray());
            }

            return response()->json(['status' => 'success']);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Get gateway configuration for frontend
     */
    public function getGatewayConfig(Request $request, string $slug)
    {
        try {
            $gateway = PaymentGateway::where('slug', $slug)
                ->where('is_active', true)
                ->first();

            if (!$gateway) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway not found.',
                ], 404);
            }

            $paymentMethod = $gateway->paymentMethod();

            $config = [
                'success' => true,
                'gateway' => [
                    'slug' => $gateway->slug,
                    'name' => $gateway->name,
                    'requires_frontend_js' => method_exists($paymentMethod, 'requiresFrontendJs')
                        ? $paymentMethod->requiresFrontendJs()
                        : false,
                ],
            ];

            // Add Stripe-specific config
            if ($gateway->slug === 'stripe') {
                $config['gateway']['publishable_key'] = config('services.stripe.key');
            }

            // Add Wallet-specific config
            if ($gateway->slug === 'wallet' && method_exists($paymentMethod, 'getWalletBalance')) {
                $walletInfo = $paymentMethod->getWalletBalance(Auth::id());
                $config['gateway']['wallet'] = $walletInfo;
            }

            return response()->json($config);
        } catch (\Exception $e) {
            Log::error('Get gateway config error', [
                'slug' => $slug,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving gateway configuration.',
                'error_details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
