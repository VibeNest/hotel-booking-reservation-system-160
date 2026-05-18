<?php

namespace App\Strategies\Payment;

interface PaymentStrategy
{
    public function pay($request, $booking);
}
