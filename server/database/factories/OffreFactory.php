<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titre' => $this->faker->words(3, true),
            'remise' => $this->faker->numberBetween(0, 50),
            'dateDebutOffre' => $this->faker->date(),
            'dateFinOffre' => $this->faker->date(),
            'description' => $this->faker->paragraph,
            'idAdmin' => 1 // Assurez-vous que cet ID correspond à un admin existant ou utilisez Admin::factory()
        ];
    }
}
