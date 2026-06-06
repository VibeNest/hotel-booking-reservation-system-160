<?php

namespace App\Specifications;

use App\Models\Room;

interface RoomSpecification
{
    public function isSatisfiedBy(Room $room): bool;
}