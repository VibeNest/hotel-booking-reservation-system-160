<?php

namespace App\Contracts;

interface PaymentStrategy
{
    public function pay(array $data): array;
}
