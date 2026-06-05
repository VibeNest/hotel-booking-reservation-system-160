<?php

namespace App\Services\Payment;

use App\Contracts\PaymentStrategy;

class CodStrategy implements PaymentStrategy
{
    public function pay(array $data)
    {
        return [
            'payment_status' => 0,
            'transaction_id' => ''
        ];
    }
}
