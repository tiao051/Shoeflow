<?php

return [
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK_URL', 'http://localhost:8000/auth/google/callback'), 
    ],
    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
    ],
    'vnpay' => [
        'tmn_code' => env('VNPAY_TMN_CODE'),
        'hash_secret' => env('VNPAY_HASH_SECRET'),
        'url' => env('VNPAY_URL'),
        'return_url' => env('VNPAY_RETURN_URL'),
    ],
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
    ],
];
