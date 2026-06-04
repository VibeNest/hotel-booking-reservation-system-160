<?php

namespace App\Context;

use App\Contracts\PaymentStrategy;

class PaymentContext
{
    private PaymentStrategy $strategy;

    public function __construct(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function execute(array $data)
    {
        return $this->strategy->pay($data);
    }
}
