<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    protected $model = \App\Models\Formation::class;

    public function definition()
    {
        return [
            'intitule' => $this->faker->word,
            'date_debut' => $this->faker->date,
            'date_fin' => $this->faker->date,
            'lieu' => $this->faker->city,
            'nbr_place' => $this->faker->numberBetween(10, 100),
        ];
    }
}