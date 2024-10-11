<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentSlipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(100000, 1000000),
            'note' => $this->faker->sentence(6),
            'client_id' => $this->faker->numberBetween(8, 32),
        ];
    }
}
