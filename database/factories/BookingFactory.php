<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'rooms_id' => null,
            'user_id' => null,
            'check_in' => $this->faker->date(),
            'check_out' => $this->faker->date(),
            'person' => $this->faker->randomDigitNotNull(),
            'number_of_rooms' => $this->faker->randomDigitNotNull(),
            'total_night' => $this->faker->randomDigit(),
            'actual_price' => $this->faker->randomFloat(2, 100, 1000),
            'subtotal' => $this->faker->randomFloat(2, 100, 1000),
            'discount' => 0,
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'payment_method' => 'online',
            'transaction_id' => null,
            'payment_status' => '0',
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),
            'state' => $this->faker->state(),
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'code' => $this->faker->unique()->numerify('###########'),
            'status' => 0,
        ];
    }

    public function pending(): self
    {
        return $this->state([
            'status' => 0,
        ]);
    }

    public function complete(): self
    {
        return $this->state([
            'status' => 1,
        ]);
    }
}
