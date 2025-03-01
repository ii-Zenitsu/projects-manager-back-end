<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Formation;
use App\Models\Personne;

class ParticipationFactory extends Factory
{
    protected $model = \App\Models\Participation::class;

    public function definition()
    {
        return [
            'formation_id' => Formation::inRandomOrder()->first()->id,
            'personne_id' => Personne::factory(),
        ];
    }
}