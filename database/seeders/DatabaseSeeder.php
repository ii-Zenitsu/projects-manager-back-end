<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Participation;
use App\Models\Personne;
use App\Models\Projet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Formation::factory(5)->create();
        Participation::factory(50)->create();
        Projet::factory(7)->create();
        $personnes = Personne::all();
        foreach ($personnes as $per) {
            $randomProjetIds = Projet::inRandomOrder()->first()->id;
            $per->projets()->attach($randomProjetIds);
        }
    }
}
