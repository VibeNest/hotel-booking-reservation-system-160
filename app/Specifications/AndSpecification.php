<?php

namespace App\Specifications;

use App\Models\Room;

class AndSpecification implements RoomSpecification
{
    private $specifications;

    public function __construct(...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(Room $room): bool
    {
        foreach ($this->specifications as $spec) {

            if (!$spec->isSatisfiedBy($room)) {
                return false;
            }

        }

        return true;
    }
}