<?php

namespace Database\Factories;

use App\Models\Activite;
use App\Models\Offre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offreactivite>
 */
class OffreActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'idOffre' => Offre::factory(),
            'idActivite' => Activite::factory(),
            'tarif' => $this->faker->randomFloat(5, 10, 1000),
            'effmax' => $this->faker->numberBetween(10, 100),
            'effmin' => $this->faker->numberBetween(1, 9),
            'age_min' => $this->faker->numberBetween(5, 10),
            'age_max' => $this->faker->numberBetween(11, 18),
            'nbrSeance' => $this->faker->numberBetween(1, 20),
            'Duree_en_heure' => $this->faker->numberBetween(1, 8),
        ];
    }
}
