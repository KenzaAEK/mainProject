<?php
namespace Database\Factories;

use App\Models\Tuteur;
use App\Models\Enfant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class EnfantFactory extends Factory
{
    public function definition()
    {
        $enfant = $this->makeEnfant();
        return [
            'idTuteur' => $this->faker->numberBetween(5, 14),
            'prenom' => $this->faker->firstName,
            'nom' => $this->faker->lastName,
            'dateNaissance' => $this->faker->date(),
            'niveauEtude' => $this->faker->randomElement(['Primaire', 'Collège', 'Lycée']),
        ];
    }
    protected function makeEnfant()
    {
        return Enfant::factory()->make();
    }

}
