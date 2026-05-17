<?php

namespace App\Strategies\Payment;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalPaymentStrategy implements PaymentStrategy
{
    public function pay($request, $booking)
    {
        $provider = new PayPalClient();

        $provider->setApiCredentials(config('paypal'));

        $token = $provider->getAccessToken();

        $provider->setAccessToken($token);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",

            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],

            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $booking['total_price']
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            foreach ($response['links'] as $link) {

                if ($link['rel'] == 'approve') {

                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->back()
            ->with('error', 'Paypal payment failed');
    }
}