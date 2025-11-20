<?php

require_once '../vendor/autoload.php';
require_once '../secrets.php';

$stripe = new \Stripe\StripeClient([
    "api_key" => $stripeSecretKey,
    "stripe_version" => "2025-10-29.clover"
]);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:8000';

$checkout_session = $stripe->checkout->sessions->create([
    'ui_mode' => 'custom',
    'line_items' => [[
        # Provide the exact Price ID (e.g. price_1234) of the product you want to sell
        'price' => '{{PRICE_ID}}',
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'return_url' => $YOUR_DOMAIN . '/complete.html?session_id={CHECKOUT_SESSION_ID}',
]);

echo json_encode(array('clientSecret' => $checkout_session->client_secret));
