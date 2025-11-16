<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show payment form
     */
    public function index()
    {
        return view('backend.user.pages.payment.index', [
            'stripe_key' => config('services.stripe.key'),
        ]);
    }

    /**
     * Process card payment
     */
    public function processCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'payment_method_id' => 'required|string',
            'card_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $result = $this->paymentService->processCardPayment($request->all());

        return response()->json($result);
    }

    /**
     * Process digital wallet payment
     */
    public function processDigitalWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'payment_method_id' => 'required|string',
            'wallet_type' => 'required|in:gpay,apple_pay',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $result = $this->paymentService->processDigitalWalletPayment($request->all());

        return response()->json($result);
    }

    /**
     * Process crypto payment
     */
    public function processCrypto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'crypto_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $result = $this->paymentService->processCryptoPayment($request->all());

        return response()->json($result);
    }

    /**
     * Payment success page
     */
    public function success()
    {
        return view('backend.user.pages.payment.success');
    }

    /**
     * Payment cancel page
     */
    public function cancel()
    {
        return view('user.payment.cancel');
    }

    /**
     * Stripe webhook
     */
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            if ($event->type === 'payment_intent.succeeded') {
                $paymentIntent = $event->data->object;
                $this->paymentService->updatePaymentStatus(
                    $paymentIntent->metadata->transaction_id ?? null,
                    'completed'
                );
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Coinbase webhook
     */
    public function coinbaseWebhook(Request $request)
    {
        // Verify webhook signature
        $signature = $request->header('X-CC-Webhook-Signature');
        
        try {
            $event = $request->all();
            
            if ($event['event']['type'] === 'charge:confirmed') {
                $chargeId = $event['event']['data']['id'];
                // Update payment status
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
