<?php

namespace Database\Factories;

use App\Models\Tuteur;
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
        $n = Tuteur::count();
        if ($n == 0) {
            echo "Il faut des Parents et des groupes pour peupler la table animateur_groupes.";
            return;
        }      
            // dd(rand(1, $n)."d and debug de enfant fact");
        return [
            'idTuteur' => rand(1, $n),
            'idEnfant' => $this->faker->unique()->randomNumber(),
            'prenom' => $this->faker->firstName,
            'dateNaissance' => $this->faker->date(),
            'niveauEtude' => $this->faker->randomElement(['Primary', 'Secondary']),
            'nom' => $this->faker->lastName,
        ];
    }
}
