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

    public function execute(array $data): array
    {
        return $this->strategy->pay($data);
    }
}
