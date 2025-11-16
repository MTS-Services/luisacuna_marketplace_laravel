<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;
use App\Services\Payment\PaymentGatewayFactory;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentCheckout extends Component
{
    public $amount = 100;
    public $description = 'Product Purchase';
    public $selectedGateway = 'stripe';
    public $clientSecret;
    public $paypalApprovalUrl;
    public $paymentIntentId;
    public $showPaymentForm = false;
    public $saveCard = false;
    public $customerId;
    public $savedCards = [];
    public $selectedCard = null;
    public $email;

    protected $rules = [
        'amount' => 'required|numeric|min:1',
        'description' => 'required|string|max:255',
        'selectedGateway' => 'required|in:stripe,paypal',
        'email' => 'required|email',
    ];

    public function mount()
    {
        $this->email = Auth::user()->email ?? '';
        $this->loadSavedCards();
    }

    public function loadSavedCards()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        
        // Assuming you store stripe_customer_id in users table
        if ($user->stripe_customer_id) {
            try {
                $gateway = PaymentGatewayFactory::create('stripe');
                $result = $gateway->getCustomerPaymentMethods($user->stripe_customer_id);
                
                if ($result['success']) {
                    $this->savedCards = collect($result['payment_methods'])->map(function ($pm) {
                        return [
                            'id' => $pm->id,
                            'brand' => $pm->card->brand ?? 'card',
                            'last4' => $pm->card->last4 ?? '****',
                            'exp_month' => $pm->card->exp_month ?? '',
                            'exp_year' => $pm->card->exp_year ?? '',
                        ];
                    })->toArray();
                    
                    $this->customerId = $user->stripe_customer_id;
                }
            } catch (\Exception $e) {
                // Silently fail - no saved cards available
            }
        }
    }

    public function updatedSelectedGateway()
    {
        $this->reset(['clientSecret', 'paypalApprovalUrl', 'paymentIntentId', 'showPaymentForm']);
    }

    public function initiatePayment()
    {
        $this->validate();

        try {
            $gateway = PaymentGatewayFactory::create($this->selectedGateway);

            // Create or get Stripe customer
            if ($this->selectedGateway === 'stripe' && Auth::check()) {
                $user = Auth::user();
                
                if (!$user->stripe_customer_id) {
                    $customerResult = $gateway->createCustomer([
                        'email' => $this->email,
                        'name' => $user->name,
                        'metadata' => ['user_id' => $user->id],
                    ]);

                    if ($customerResult['success']) {
                        $user->update(['stripe_customer_id' => $customerResult['customer_id']]);
                        $this->customerId = $customerResult['customer_id'];
                    }
                } else {
                    $this->customerId = $user->stripe_customer_id;
                }
            }

            $data = [
                'amount' => $this->amount,
                'currency' => 'USD',
                'description' => $this->description,
                'receipt_email' => $this->email,
                'metadata' => [
                    'user_id' => Auth::id(),
                    'description' => $this->description,
                ],
            ];

            // Add customer ID for Stripe
            if ($this->selectedGateway === 'stripe' && $this->customerId) {
                $data['customer_id'] = $this->customerId;
            }

            if ($this->selectedGateway === 'paypal') {
                $data['return_url'] = route('payment.paypal.success');
                $data['cancel_url'] = route('payment.paypal.cancel');
            }

            $result = $gateway->createPaymentIntent($data);

            if ($result['success']) {
                // Store pending payment
                Payment::create([
                    'user_id' => Auth::id(),
                    'payment_gateway' => $this->selectedGateway,
                    'transaction_id' => $result['payment_intent_id'] ?? $result['payment_id'],
                    'payment_intent_id' => $result['payment_intent_id'] ?? $result['payment_id'],
                    'amount' => $this->amount,
                    'currency' => 'USD',
                    'status' => 'pending',
                    'description' => $this->description,
                    'metadata' => [
                        'save_card' => $this->saveCard,
                    ],
                ]);

                if ($this->selectedGateway === 'stripe') {
                    $this->clientSecret = $result['client_secret'];
                    $this->paymentIntentId = $result['payment_intent_id'];
                    $this->showPaymentForm = true;
                    $this->dispatch('stripePaymentIntentCreated', [
                        'clientSecret' => $this->clientSecret,
                        'saveCard' => $this->saveCard,
                        'customerId' => $this->customerId,
                    ]);
                } else {
                    $this->paypalApprovalUrl = $result['approval_url'];
                    return redirect($this->paypalApprovalUrl);
                }

                session()->flash('message', 'Payment initiated successfully!');
            } else {
                session()->flash('error', $result['message'] ?? 'Payment initiation failed.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function payWithSavedCard()
    {
        if (!$this->selectedCard) {
            session()->flash('error', 'Please select a saved card.');
            return;
        }

        $this->validate(['amount' => 'required|numeric|min:1']);

        try {
            $gateway = PaymentGatewayFactory::create('stripe');

            $data = [
                'amount' => $this->amount,
                'currency' => 'USD',
                'description' => $this->description,
                'customer_id' => $this->customerId,
                'payment_method_types' => ['card'],
                'receipt_email' => $this->email,
                'metadata' => [
                    'user_id' => Auth::id(),
                ],
            ];

            $result = $gateway->createPaymentIntent($data);

            if ($result['success']) {
                // Confirm payment with saved card
                $confirmResult = $gateway->confirmPaymentIntent(
                    $result['payment_intent_id'],
                    $this->selectedCard
                );

                if ($confirmResult['success'] && $confirmResult['status'] === 'succeeded') {
                    Payment::create([
                        'user_id' => Auth::id(),
                        'payment_gateway' => 'stripe',
                        'transaction_id' => $result['payment_intent_id'],
                        'payment_intent_id' => $result['payment_intent_id'],
                        'amount' => $this->amount,
                        'currency' => 'USD',
                        'status' => 'completed',
                        'description' => $this->description,
                        'paid_at' => now(),
                    ]);

                    session()->flash('success', 'Payment completed successfully with saved card!');
                    $this->reset(['amount', 'description', 'selectedCard']);
                } else {
                    session()->flash('error', 'Payment confirmation failed.');
                }
            } else {
                session()->flash('error', $result['message'] ?? 'Payment failed.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function handleStripeSuccess($paymentIntentId)
    {
        try {
            $gateway = PaymentGatewayFactory::create('stripe');
            $result = $gateway->processPayment(['payment_intent_id' => $paymentIntentId]);

            if ($result['success']) {
                Payment::where('payment_intent_id', $paymentIntentId)->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'transaction_id' => $result['charge_id'] ?? $paymentIntentId,
                    'metadata' => [
                        'receipt_url' => $result['receipt_url'] ?? null,
                    ],
                ]);

                session()->flash('success', 'Payment completed successfully!');
                $this->reset(['amount', 'description', 'showPaymentForm', 'clientSecret', 'paymentIntentId']);
                
                // Reload saved cards if card was saved
                if ($this->saveCard) {
                    $this->loadSavedCards();
                }
            } else {
                session()->flash('error', 'Payment verification failed.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.user.payment-checkout', [
            'availableGateways' => PaymentGatewayFactory::getAvailableGateways(),
        ]);
    }
}
