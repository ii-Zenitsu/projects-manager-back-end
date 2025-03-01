<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjetFactory extends Factory
{
    protected $model = \App\Models\Projet::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $duration = $this->faker->numberBetween(30, 180);
        $endDate = Carbon::parse($startDate)->addDays($duration);

        return [
            'intitule' => $this->faker->sentence(3),
            'dateDebut' => $startDate,
            'dateFin' => $endDate,
            'duree' => $duration,
        ];
    }
}