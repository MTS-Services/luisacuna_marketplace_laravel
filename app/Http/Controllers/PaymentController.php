<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initialize payment (create payment intent)
     */
    public function initializePayment(Request $request)
    {
        try {
            // Validate input
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

            // Get order
            $order = Order::where('order_id', $request->input('order_id'))->first();

            if (!$order) {
                Log::warning('Order not found', ['order_id' => $request->input('order_id')]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            // Get payment gateway
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

            // Get payment method instance
            $paymentMethod = $gateway->paymentMethod();

            // Initialize payment (creates payment intent)
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

    /**
     * Confirm payment (after frontend processing)
     */
    public function confirmPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payment_intent_id' => 'required|string',
                'payment_method_id' => 'nullable|string',
                'gateway' => 'required|string|exists:payment_gateways,slug',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Get payment gateway
            $gateway = PaymentGateway::where('slug', $request->input('gateway'))->first();

            if (!$gateway) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway not found.',
                ], 404);
            }

            // Get payment method instance
            $paymentMethod = $gateway->paymentMethod();

            // Confirm payment
            $result = $paymentMethod->confirmPayment(
                $request->input('payment_intent_id'),
                $request->input('payment_method_id')
            );

            Log::info('Payment confirmed', [
                'payment_intent_id' => $request->input('payment_intent_id'),
                'result' => $result,
            ]);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Payment confirmation error', [
                'payment_intent_id' => $request->input('payment_intent_id'),
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

    /**
     * Payment success page
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::where('order_id', $orderId)->with('latestPayment')->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        return view('payment.success', compact('order'));
    }

    /**
     * Payment failed page
     */
    public function paymentFailed(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::where('order_id', $orderId)->with('latestPayment')->first();

        return view('payment.failed', compact('order'));
    }

    /**
     * Handle Stripe webhook
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

            Log::info('Stripe webhook received', ['event_type' => $event['type'] ?? 'unknown']);

            // Get payment gateway
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

    /**
     * Get payment gateway configuration for frontend
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

            return response()->json([
                'success' => true,
                'gateway' => [
                    'slug' => $gateway->slug,
                    'name' => $gateway->name,
                    'requires_frontend_js' => method_exists($paymentMethod, 'requiresFrontendJs') ? $paymentMethod->requiresFrontendJs() : false,
                    'js_sdk_url' => method_exists($paymentMethod, 'getJsSDKUrl') ? $paymentMethod->getJsSDKUrl() : null,
                    'publishable_key' => $gateway->slug === 'stripe' ? config('services.stripe.key') : null,
                ],
            ]);
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