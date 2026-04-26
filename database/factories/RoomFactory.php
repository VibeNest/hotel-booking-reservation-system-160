<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'roomtype_id' => 1, // hoặc random nếu có bảng room_types

            'total_adult' => fake()->numberBetween(1, 4),
            'total_child' => fake()->numberBetween(0, 3),
            'room_capacity' => fake()->numberBetween(1, 6),

            'image' => 'test.jpg', // chỉ cần string

            'price' => fake()->numberBetween(50, 500),
            'size' => fake()->numberBetween(20, 100),

            'view' => fake()->randomElement(['Sea', 'City', 'Garden']),
            'bed_style' => fake()->randomElement(['Single', 'Double', 'King']),

            'discount' => fake()->randomElement([0, 10, 20]),

            'short_desc' => fake()->sentence(),
            'description' => fake()->paragraph(),

            'status' => 1,
        ];
    }
}