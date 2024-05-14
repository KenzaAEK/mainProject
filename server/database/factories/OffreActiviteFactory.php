<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre_activite>
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
            'idOffre' => \App\Models\Offre::factory(),
            'idActivite' => \App\Models\Activite::factory(),
            'tarif' => $this->faker->randomFloat(2, 10, 100),
            'effmax' => $this->faker->numberBetween(5, 20),
            'effmin' => $this->faker->numberBetween(1, 5),
            'age_min' => $this->faker->numberBetween(5, 12),
            'age_max' => $this->faker->numberBetween(13, 18),
            'nbrSeance' => $this->faker->numberBetween(1, 10),
            'Duree_en_heure' => $this->faker->numberBetween(1, 3)
        ];
    }
}
