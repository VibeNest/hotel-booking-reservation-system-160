<?php

namespace App\Services\Pricing;

final class FacilityFeeDecorator implements RoomPrice
{
    public function __construct(private RoomPrice $inner, private float $fee) {}

    public function total(): float
    {
        return $this->inner->total() + $this->fee;
    }
}
