<?php

namespace Database\Factories;

use App\Models\Tuteur;
use App\Models\Enfant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enfant>
 */
class EnfantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
