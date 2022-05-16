<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'identify' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'telephone' => $this->faker->phoneNumber(),
            'user_id' => 0,
             ];
    }
}
