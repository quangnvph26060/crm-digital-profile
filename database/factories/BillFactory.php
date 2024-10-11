<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => $this->faker->numberBetween(8, 32),
            'total_money' => $this->faker->numberBetween(100000, 1000000),
            'tax' => $this->faker->numberBetween(10, 50),
            'created_at' => $this->faker->dateTimeBetween('2024-08-01', 'now'),
        ];
    }
}
