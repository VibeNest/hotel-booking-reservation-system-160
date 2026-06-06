<?php

namespace App\Services\Pricing;

final class BaseRoomPrice implements RoomPrice
{
    public function __construct(private float $baseTotal) {}

    public function total(): float
    {
        return $this->baseTotal;
    }
}
