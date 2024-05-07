<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activite>
 */
class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'prix' => $this->faker->randomFloat(2, 10, 100), // random price between 10 and 100
            'ageMin' => $this->faker->numberBetween(5, 10),
            'ageMax' => $this->faker->numberBetween(11, 15),
            'imagePub' => $this->faker->imageUrl(),
            'lienYtb' => $this->faker->randomNumber(7, true), // generates a "YouTube-like" ID
            'programmePdf' => $this->faker->url,
            'idTypeActivite' => \App\Models\TypeActivite::factory(), // Ensure you have a TypeActiviteFactory
        ];
    }
}
