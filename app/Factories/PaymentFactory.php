<?php

namespace App\Factories;

use App\Services\Payment\CodStrategy;
use App\Services\Payment\StripeStrategy;

class PaymentFactory
{
    public static function make($method)
    {
        return match ($method) {
            'COD' => new CodStrategy(),
            'Stripe' => new StripeStrategy(),

            default => throw new \Exception('Invalid Payment Method')
        };
    }
}
