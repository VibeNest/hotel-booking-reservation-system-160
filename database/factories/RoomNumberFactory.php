<?php

namespace Database\Factories;

use App\Models\RoomNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomNumber>
 */
class RoomNumberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'room_type_id' => 1,
            'rooms_id' => 1,
            'room_number' => fake()->unique()->numerify('###'),
            'status' => 'Active',
        ];
    }
}