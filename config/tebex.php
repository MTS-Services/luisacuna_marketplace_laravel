<?php

return [
    'project_id' => env('TEBEX_PROJECT_ID'),
    'public_token' => env('TEBEX_PUBLIC_TOKEN'),
    'private_key' => env('TEBEX_PRIVATE_KEY'),
    'checkout_url' => env('TEBEX_CHECKOUT_URL', 'https://checkout.tebex.io/api'),
];
