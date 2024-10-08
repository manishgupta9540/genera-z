<?php

return [
    'merchant_id' => env('CCAVENUE_MERCHANT_ID'),
    'access_code' => env('CCAVENUE_ACCESS_CODE'),
    'encryption_key' => env('CCAVENUE_ENCRYPTION_KEY'),
    'payment_url' => env('CCAVENUE_PAYMENT_URL'),
    'redirect_url' => env('CCAVENUE_REDIRECT_URL',env('APP_URL').'/payment/callback'),
    'cancel_url' => env('CCAVENUE_CANCEL_URL',env('APP_URL').'/payment/callback'),
];
