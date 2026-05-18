<?php

namespace App\Services;

use App\Strategies\Payment\PaymentStrategy;

class PaymentContext
{
    protected $strategy;

    public function __construct(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function execute($request, $booking)
    {
        return $this->strategy->pay($request, $booking);
    }
}
