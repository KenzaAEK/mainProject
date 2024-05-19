<?php
namespace Database\Factories;

use App\Models\Tuteur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class EnfantFactory extends Factory
{
    public function definition()
    {
        return [
            'idTuteur' => Tuteur::factory()->create()->idTuteur,
            'idEnfant' => $this->faker->unique()->randomNumber(),
            'prenom' => $this->faker->firstName,
            'dateNaissance' => $this->faker->date(),
            'niveauEtude' => $this->faker->randomElement(['Primary', 'Secondary']),
            'nom' => $this->faker->lastName,
        ];
    }
}
