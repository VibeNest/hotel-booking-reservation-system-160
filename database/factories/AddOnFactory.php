<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddOnFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 5, 100), // giá từ 5 đến 100
            'description' => $this->faker->sentence(),
        ];
    }
}