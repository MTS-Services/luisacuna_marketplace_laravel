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

class PaymentController extends Controller
{
    public function __construct(protected ConversationService $conversationService) {}

    public function initializePayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,order_id',
                'gateway' => 'required|string|exists:payment_gateways,slug',
            ]);

            if ($validator->fails()) {
                Log::warning('Payment initialization validation failed', [
                    'errors' => $validator->errors(),
                    'input' => $request->all(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $order = Order::where('order_id', $request->input('order_id'))->first();

            if (!$order) {
                Log::warning('Order not found', ['order_id' => $request->input('order_id')]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            $gateway = PaymentGateway::where('slug', $request->input('gateway'))
                ->where('is_active', true)
                ->first();

            if (!$gateway) {
                Log::warning('Payment gateway not found or inactive', [
                    'gateway_slug' => $request->input('gateway'),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Selected payment gateway is not available.',
                ], 404);
            }

            $conversation = $this->conversationService->sendOrderMessage($order);

            Log::info('Order conversation started', [
                'order_id' => $order->order_id,
                'conversation_id' => $conversation->id,
                'conversation_uuid' => $conversation->conversation_uuid,
            ]);

            $paymentMethod = $gateway->paymentMethod();
            $result = $paymentMethod->startPayment($order);

            Log::info('Payment initialized successfully', [
                'order_id' => $order->order_id,
                'gateway' => $gateway->slug,
                'result' => $result,
            ]);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Payment initialization error', [
                'order_id' => $request->input('order_id'),
                'gateway' => $request->input('gateway'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while initializing payment: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

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

            Log::info('Payment confirmed', [
                'session_id' => $request->input('session_id'),
                'result' => $result,
            ]);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Payment confirmation error', [
                'session_id' => $request->input('session_id'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while confirming payment: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $sessionId = $request->query('session_id');

        // If coming from Stripe, confirm the payment
        if ($sessionId) {
            $gateway = PaymentGateway::where('slug', 'stripe')->first();
            if ($gateway) {
                $paymentMethod = $gateway->paymentMethod();
                $paymentMethod->confirmPayment($sessionId);
            }
        }

        $order = Order::where('order_id', $orderId)->with(['latestPayment', 'source'])->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        return view('payment.success', compact('order'));
    }

    public function paymentFailed(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::where('order_id', $orderId)->with(['latestPayment', 'source'])->first();

        return view('payment.failed', compact('order'));
    }

    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            if ($webhookSecret) {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $sigHeader,
                    $webhookSecret
                );
            } else {
                $event = json_decode($payload, true);
            }

            Log::info('Stripe webhook received', ['event_type' => $event['type'] ?? 'unknown']);

            $gateway = PaymentGateway::where('slug', 'stripe')->first();

            if ($gateway) {
                $paymentMethod = $gateway->paymentMethod();
                $paymentMethod->handleWebhook(is_array($event) ? $event : $event->toArray());
            }

            return response()->json(['status' => 'success']);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

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
                    'requires_frontend_js' => method_exists($paymentMethod, 'requiresFrontendJs') ? $paymentMethod->requiresFrontendJs() : false,
                ],
            ];

            // Add Stripe-specific config
            if ($gateway->slug === 'stripe') {
                $config['gateway']['publishable_key'] = config('services.stripe.key');
            }

            // Add Wallet-specific config
            if ($gateway->slug === 'wallet') {
                $walletInfo = $paymentMethod->getWalletBalance(Auth::id());
                $config['gateway']['wallet'] = $walletInfo;
            }

            return response()->json($config);
        } catch (\Exception $e) {
            Log::error('Get gateway config error', [
                'slug' => $slug,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving gateway configuration: ' . $e->getMessage(),
            ], 500);
        }
    }
}