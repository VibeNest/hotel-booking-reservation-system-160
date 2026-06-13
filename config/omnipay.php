<?php

return [
    'gateways' => [
        'VNPay' => [
            'tmn_code' => env('VNP_TMN_CODE', ''),
            'hash_secret' => env('VNP_HASH_SECRET', ''),
            'return_url' => env('VNP_RETURN_URL', env('APP_URL').'/vnpay-return'),
            'test_mode' => env('VNP_TEST_MODE', true),
            'currency' => env('VNP_CURRENCY', 'VND'),
            'locale' => env('VNP_LOCALE', 'vi'),
        ],
    ],
];
