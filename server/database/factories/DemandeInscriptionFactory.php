<?php

namespace Database\Factories;

use App\Models\Pack;
use App\Models\Tuteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demande_inscription>
 */
class DemandeInscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'optionsPaiement' => $this->faker->randomElement(['mensuel', 'trimestriel', 'annuel']),
            'status' => $this->faker->randomElement(['en attente', 'acceptée', 'refusée']),
            'dateDemande' => $this->faker->date(),
            'idPack' => Pack::factory()->create()->idPack,
            'idTuteur' => Tuteur::factory()->create()->idTuteur,
        ];
    }
}
