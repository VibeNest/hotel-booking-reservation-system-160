<?php

namespace App\Services\Payment;

use App\Contracts\PaymentStrategy;
use Stripe;

class StripeStrategy implements PaymentStrategy
{
    public function pay(array $data)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $payment = Stripe\Charge::create([
            'amount' => $data['total_price'] * 100,
            'currency' => 'usd',
            'source' => $data['stripeToken'],
            'description' => 'Booking Payment',
        ]);

        if ($payment['status'] == 'succeeded') {

            return [
                'payment_status' => 1,
                'transaction_id' => $payment['id'],
            ];
        }

        throw new \Exception('Stripe Payment Failed');
    }
}
