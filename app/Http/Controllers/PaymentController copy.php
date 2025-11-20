<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\TestItem;
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

    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,order_id',
            'cardNumber' => 'required|string',
            'cardExpiry' => 'required|string',
            'cardCvc' => 'required|string',
            'gateway' => 'required|string|exists:payment_gateways,slug',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $order = Order::where('order_id', $request->input('order_id'))->first();

        $gateway = PaymentGateway::where('slug', $request->input('gateway'))->first();

        $gateway = $gateway->paymentMethod()->startPayment($order, [
            'card_number' => $request->input('cardNumber'),
            'card_expiry' => $request->input('cardExpiry'),
            'card_cvc' => $request->input('cardCvc'),
        ]);
    }


    /**
     * Process card payment
     */
    // public function processCard(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'amount' => 'required|numeric|min:0.01',
    //         'payment_method_id' => 'required|string',
    //         'card_type' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     $result = $this->paymentService->processCardPayment($request->all());

    //     return response()->json($result);
    // }

    /**
     * Process digital wallet payment
     */
    public function processDigitalWallet(Request $request)
    {
        //
    }

    /**
     * Process crypto payment
     */
    public function processCrypto(Request $request)
    {
        //
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
        //
    }

    /**
     * Coinbase webhook
     */
    public function coinbaseWebhook(Request $request)
    {
        //
    }
}
