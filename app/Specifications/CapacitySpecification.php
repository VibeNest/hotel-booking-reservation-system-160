<?php

namespace App\Specifications;

use App\Models\Room;

class CapacitySpecification implements RoomSpecification
{
    private $person;

    public function __construct($person)
    {
        $this->person = $person;
    }

    public function isSatisfiedBy(Room $room): bool
    {
        $capacity = $room->total_adult + $room->total_child;

        return $this->person <= $capacity;
    }
}