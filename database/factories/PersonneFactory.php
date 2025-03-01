<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonneFactory extends Factory
{
    protected $model = \App\Models\Personne::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'tele' => $this->faker->phoneNumber,
        ];
    }
}