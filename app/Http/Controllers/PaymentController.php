<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Services\ConversationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct(protected ConversationService $conversationService) {}

    /**
     * Initialize payment with security checks
     */
    public function initializePayment(Request $request)
    {
        try {
            // 1. Validate input
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|string|exists:orders,order_id',
                'gateway' => 'required|string|exists:payment_gateways,slug',
            ]);

            if ($validator->fails()) {
                Log::warning('Payment initialization validation failed', [
                    'errors' => $validator->errors(),
                    'input' => $request->all(),
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // 2. Get and verify order
            $order = Order::where('order_id', $request->input('order_id'))->first();

            if (!$order) {
                Log::warning('Order not found', [
                    'order_id' => $request->input('order_id'),
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            // 3. Security: Verify order belongs to authenticated user
            if ($order->user_id !== Auth::id()) {
                Log::warning('Unauthorized order access attempt', [
                    'order_id' => $order->order_id,
                    'order_user_id' => $order->user_id,
                    'requesting_user_id' => Auth::id(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this order.',
                ], 403);
            }

            // 4. Verify order status
            if ($order->status !== OrderStatus::INITIALIZED) {
                Log::warning('Invalid order status for payment', [
                    'order_id' => $order->order_id,
                    'status' => $order->status->value,
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'This order cannot be paid. Status: ' . $order->status->label(),
                ], 400);
            }

            // 5. Check if payment already exists and is completed
            $existingPayment = Payment::where('order_id', $order->id)
                ->whereIn('status', ['success', 'completed'])
                ->first();

            if ($existingPayment) {
                Log::info('Payment already completed for order', [
                    'order_id' => $order->order_id,
                    'payment_id' => $existingPayment->payment_id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'This order has already been paid.',
                    'redirect_url' => route('user.payment.success', ['order_id' => $order->order_id]),
                ], 400);
            }

            // 6. Get and verify payment gateway
            $gateway = PaymentGateway::where('slug', $request->input('gateway'))
                ->where('is_active', true)
                ->first();

            if (!$gateway) {
                Log::warning('Payment gateway not found or inactive', [
                    'gateway_slug' => $request->input('gateway'),
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Selected payment gateway is not available.',
                ], 404);
            }

            // 7. Verify gateway is supported
            if (!$gateway->isSupported()) {
                Log::warning('Payment gateway not supported', [
                    'gateway_slug' => $gateway->slug,
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'This payment gateway is currently not supported.',
                ], 400);
            }

            // 8. Create conversation for order (if service exists)
            try {
                $conversation = $this->conversationService->sendOrderMessage($order);

                Log::info('Order conversation started', [
                    'order_id' => $order->order_id,
                    'conversation_id' => $conversation->id ?? null,
                    'conversation_uuid' => $conversation->conversation_uuid ?? null,
                ]);
            } catch (\Exception $e) {
                // Log but don't fail payment if conversation fails
                Log::warning('Failed to create order conversation', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage(),
                ]);
            }

            // 9. Start payment via payment method
            DB::beginTransaction();

            try {
                $paymentMethod = $gateway->paymentMethod();
                $result = $paymentMethod->startPayment($order, $request->all());

                // If payment was successful, commit transaction
                if ($result['success']) {
                    DB::commit();

                    Log::info('Payment initialized successfully', [
                        'order_id' => $order->order_id,
                        'gateway' => $gateway->slug,
                        'user_id' => Auth::id(),
                        'payment_id' => $result['payment_id'] ?? null,
                    ]);

                    return response()->json($result);
                } else {
                    DB::rollBack();

                    Log::warning('Payment initialization failed', [
                        'order_id' => $order->order_id,
                        'gateway' => $gateway->slug,
                        'message' => $result['message'] ?? 'Unknown error',
                    ]);

                    return response()->json($result, 400);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Payment initialization error', [
                'order_id' => $request->input('order_id'),
                'gateway' => $request->input('gateway'),
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while initializing payment. Please try again.',
                'error_details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Confirm payment after external processing (Stripe)
     */
    public function confirmPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'session_id' => 'required|string',
                'gateway' => 'required|string|exists:payment_gateways,slug',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $gateway = PaymentGateway::where('slug', $request->input('gateway'))->first();

            if (!$gateway) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway not found.',
                ], 404);
            }

            $paymentMethod = $gateway->paymentMethod();
            $result = $paymentMethod->confirmPayment($request->input('session_id'));

            // Security: Verify the confirmed payment belongs to current user
            if ($result['success'] && isset($result['payment'])) {
                $payment = $result['payment'];
                if ($payment->user_id !== Auth::id()) {
                    Log::warning('Unauthorized payment confirmation attempt', [
                        'payment_id' => $payment->payment_id,
                        'payment_user_id' => $payment->user_id,
                        'requesting_user_id' => Auth::id(),
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access.',
                    ], 403);
                }
            }

            Log::info('Payment confirmed', [
                'session_id' => $request->input('session_id'),
                'gateway' => $request->input('gateway'),
                'user_id' => Auth::id(),
            ]);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Payment confirmation error', [
                'session_id' => $request->input('session_id'),
                'gateway' => $request->input('gateway'),
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while confirming payment.',
                'error_details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

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

        try {
            $conversation = $this->conversationService->sendOrderMessage($order);

            Log::info('Order conversation started', [
                'order_id' => $order->order_id,
                'conversation_id' => $conversation->id ?? null,
                'conversation_uuid' => $conversation->conversation_uuid ?? null,
            ]);
        } catch (\Exception $e) {
            // Log but don't fail payment if conversation fails
            Log::warning('Failed to create order conversation', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }

        return view('payment.success', compact('order'));
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
