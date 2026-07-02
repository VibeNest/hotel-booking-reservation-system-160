<?php

use App\Services\Payment\CodStrategy;

it('calculates a cod deposit and remaining balance', function () {
    $result = (new CodStrategy)->pay([
        'total_price' => 1000,
    ]);

    expect($result)->toMatchArray([
        'payment_status' => 0,
        'deposit_percentage' => 30,
        'deposit_amount' => 300.0,
        'remaining_amount' => 700.0,
    ]);
});

it('caps cod deposit percentage between twenty and thirty', function () {
    $result = (new CodStrategy)->pay([
        'total_price' => 1000,
        'deposit_percentage' => 10,
    ]);

    expect($result['deposit_percentage'])->toBe(20)
        ->and($result['deposit_amount'])->toBe(200.0)
        ->and($result['remaining_amount'])->toBe(800.0);
});
