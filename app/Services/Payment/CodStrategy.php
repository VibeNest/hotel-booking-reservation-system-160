<?php

namespace App\Services\Payment;

use App\Contracts\PaymentStrategy;

class CodStrategy implements PaymentStrategy
{
    public function pay(array $data): array
    {
        $totalPrice = (float) ($data['total_price'] ?? 0);
        $depositPercentage = (int) ($data['deposit_percentage'] ?? config('booking.cod_deposit_percentage', 30));
        $depositPercentage = max(20, min(30, $depositPercentage));
        $depositAmount = round($totalPrice * ($depositPercentage / 100), 2);

        return [
            'payment_status' => 0,
            'transaction_id' => '',
            'deposit_percentage' => $depositPercentage,
            'deposit_amount' => $depositAmount,
            'remaining_amount' => round(max(0, $totalPrice - $depositAmount), 2),
        ];
    }
}
